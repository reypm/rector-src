<?php

declare(strict_types=1);

namespace Rector\Tests\TypeDeclaration\Rector\ClassMethod\ReturnTypeFromStrictTypedCallRector;

use Iterator;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;

final class Php80Test extends AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(string $filePath): void
    {
        $this->doTestFile($filePath);
    }

    public function provideData(): Iterator
    {
        return $this->yieldFilesFromDirectory(__DIR__ . '/FixturePhp80');
    }

    public function provideConfigFilePath(): string
    {
        return __DIR__ . '/config/php80_rule.php';
    }
}
