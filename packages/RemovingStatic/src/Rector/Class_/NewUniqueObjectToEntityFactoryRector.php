<?php

declare(strict_types=1);

namespace Rector\RemovingStatic\Rector\Class_;

use PhpParser\Node;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Expr\New_;
use PhpParser\Node\Expr\PropertyFetch;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\Stmt\Class_;
use Rector\Exception\ShouldNotHappenException;
use Rector\Naming\PropertyNaming;
use Rector\NodeContainer\ParsedNodesByType;
use Rector\Rector\AbstractRector;
use Rector\RectorDefinition\CodeSample;
use Rector\RectorDefinition\RectorDefinition;
use Rector\RemovingStatic\StaticTypesInClassResolver;
use Symplify\PackageBuilder\Reflection\PrivatesAccessor;

/**
 * Depends on @see PassFactoryToUniqueObjectRector
 */
final class NewUniqueObjectToEntityFactoryRector extends AbstractRector
{
    /**
     * @var string[]
     */
    private $matchedTypes = [];

    /**
     * @var PropertyNaming
     */
    private $propertyNaming;

    /**
     * @var string[]
     */
    private $typesToServices = [];

    /**
     * @var ParsedNodesByType
     */
    private $parsedNodesByType;

    /**
     * @var StaticTypesInClassResolver
     */
    private $staticTypesInClassResolver;

    /**
     * @var string[]
     */
    private $classesUsingTypes = [];

    /**
     * @param string[] $typesToServices
     */
    public function __construct(
        PropertyNaming $propertyNaming,
        ParsedNodesByType $parsedNodesByType,
        StaticTypesInClassResolver $staticTypesInClassResolver,
        array $typesToServices = []
    ) {
        $this->propertyNaming = $propertyNaming;
        $this->typesToServices = $typesToServices;
        $this->parsedNodesByType = $parsedNodesByType;
        $this->staticTypesInClassResolver = $staticTypesInClassResolver;
    }

    public function getDefinition(): RectorDefinition
    {
        return new RectorDefinition('Convert new X to new factories', [
            new CodeSample(
                <<<'CODE_SAMPLE'
<?php

class SomeClass
{
    public function run()
    {
        return new AnotherClass;
    }
}

class AnotherClass
{
    public function someFun()
    {
        return StaticClass::staticMethod();
    }
}
CODE_SAMPLE
                ,
                <<<'CODE_SAMPLE'
class SomeClass
{
    public function __construct(AnotherClassFactory $anotherClassFactory)
    {
        $this->anotherClassFactory = $anotherClassFactory;
    }

    public function run()
    {
        return $this->anotherClassFactory->create();
    }
}

class AnotherClass
{
    public function someFun()
    {
        return StaticClass::staticMethod();
    }
}
CODE_SAMPLE
            ), ]);
    }

    /**
     * @return string[]
     */
    public function getNodeTypes(): array
    {
        return [Class_::class];
    }

    /**
     * @param Class_ $node
     */
    public function refactor(Node $node): ?Node
    {
        $this->matchedTypes = [];

        // collect classes with new to factory in all classes
        $classesUsingTypes = $this->resolveClassesUsingTypes();

        $this->traverseNodesWithCallable($node->stmts, function (Node $node) use (
            $classesUsingTypes
        ): ?MethodCall {
            if (! $node instanceof New_) {
                return null;
            }

            $class = $this->getName($node->class);

            if (! in_array($class, $classesUsingTypes, true)) {
                return null;
            }

            $this->matchedTypes[] = $class;

            $propertyName = $this->propertyNaming->fqnToVariableName($class) . 'Factory';
            $propertyFetch = new PropertyFetch(new Variable('this'), $propertyName);

            return new MethodCall($propertyFetch, 'create', $node->args);
        });

        foreach ($this->matchedTypes as $matchedType) {
            $propertyName = $this->propertyNaming->fqnToVariableName($matchedType) . 'Factory';
            $this->addPropertyToClass($node, $matchedType . 'Factory', $propertyName);
        }

        return $node;
    }

    /**
     * @return string[]
     */
    private function resolveClassesUsingTypes(): array
    {
        if ($this->classesUsingTypes !== []) {
            return $this->classesUsingTypes;
        }

        // temporary
        $classes = (new PrivatesAccessor())->getPrivateProperty($this->parsedNodesByType, 'classes');
        if ($classes === []) {
            return [];
        }

        foreach ($classes as $class) {
            $hasTypes = (bool) $this->staticTypesInClassResolver->collectStaticCallTypeInClass(
                $class,
                $this->typesToServices
            );
            if ($hasTypes) {
                $name = $this->getName($class);
                if ($name === null) {
                    throw new ShouldNotHappenException();
                }
                $this->classesUsingTypes[] = $name;
            }
        }

        $this->classesUsingTypes = (array) array_unique($this->classesUsingTypes);

        return $this->classesUsingTypes;
    }
}
