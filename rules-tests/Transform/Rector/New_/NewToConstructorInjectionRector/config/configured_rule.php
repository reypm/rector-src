<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;
use Rector\Tests\Transform\Rector\New_\NewToConstructorInjectionRector\Source\DummyValidator;
use Rector\Transform\Rector\New_\NewToConstructorInjectionRector;

return static function (RectorConfig $rectorConfig): void {
    $rectorConfig
        ->ruleWithConfiguration(NewToConstructorInjectionRector::class, [DummyValidator::class]);
};
