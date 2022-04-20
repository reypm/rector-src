<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;
use Rector\DeadCode\Rector\For_\RemoveDeadContinueRector;

return static function (RectorConfig $rectorConfig): void {
    $rectorConfig->rule(RemoveDeadContinueRector::class);
};
