<?php

declare(strict_types=1);

namespace Rector\Core\Autoloading;

use Rector\Core\Configuration\Option;
use Rector\Core\Configuration\Parameter\ParameterProvider;
use Rector\Core\StaticReflection\DynamicSourceLocatorDecorator;
use Symfony\Component\Console\Input\InputInterface;
use Webmozart\Assert\Assert;

/**
 * Should it pass autoload files/directories to PHPStan analyzer?
 */
final class AdditionalAutoloader
{
    public function __construct(
        private readonly ParameterProvider $parameterProvider,
        private readonly DynamicSourceLocatorDecorator $dynamicSourceLocatorDecorator
    ) {
    }

    public function autoloadInput(InputInterface $input): void
    {
        if (! $input->hasOption(Option::AUTOLOAD_FILE)) {
            return;
        }

        /** @var string|null $autoloadFile */
        $autoloadFile = $input->getOption(Option::AUTOLOAD_FILE);
        if ($autoloadFile === null) {
            return;
        }

        Assert::fileExists($autoloadFile, sprintf('Extra autoload file %s was not found', $autoloadFile));

        require_once $autoloadFile;
    }

    public function autoloadPaths(): void
    {
        $autoloadPaths = $this->parameterProvider->provideArrayParameter(Option::AUTOLOAD_PATHS);
        $this->dynamicSourceLocatorDecorator->addPaths($autoloadPaths);
    }
}
