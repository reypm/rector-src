<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;
use Rector\Php52\Rector\Switch_\ContinueToBreakInSwitchRector;

return static function (RectorConfig $rectorConfig): void {
    $rectorConfig->rule(ContinueToBreakInSwitchRector::class);
};
