<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;
use Rector\TypeDeclaration\Rector\ClassMethod\AddVoidReturnTypeWhereNoReturnRector;

return static function (RectorConfig $rectorConfig): void {
    $rectorConfig
        ->ruleWithConfiguration(AddVoidReturnTypeWhereNoReturnRector::class, [
            AddVoidReturnTypeWhereNoReturnRector::USE_PHPDOC => true,
        ]);
};
