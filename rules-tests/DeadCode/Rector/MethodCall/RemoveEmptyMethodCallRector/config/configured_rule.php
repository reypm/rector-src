<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;
use Rector\DeadCode\Rector\MethodCall\RemoveEmptyMethodCallRector;

return static function (RectorConfig $rectorConfig): void {
    $rectorConfig->rule(RemoveEmptyMethodCallRector::class);
};
