<?php

declare(strict_types=1);

use Rector\CodeQuality\Rector\If_\SimplifyIfNullableReturnRector;
use Rector\Config\RectorConfig;

return static function (RectorConfig $rectorConfig): void {
    $rectorConfig->rule(SimplifyIfNullableReturnRector::class);
};
