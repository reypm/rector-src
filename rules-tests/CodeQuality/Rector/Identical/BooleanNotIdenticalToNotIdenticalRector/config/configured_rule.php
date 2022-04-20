<?php

declare(strict_types=1);

use Rector\CodeQuality\Rector\Identical\BooleanNotIdenticalToNotIdenticalRector;
use Rector\Config\RectorConfig;

return static function (RectorConfig $rectorConfig): void {
    $rectorConfig->rule(BooleanNotIdenticalToNotIdenticalRector::class);
};
