<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;
use Rector\DeadCode\Rector\Expression\SimplifyMirrorAssignRector;

return static function (RectorConfig $rectorConfig): void {
    $rectorConfig->rule(SimplifyMirrorAssignRector::class);
};
