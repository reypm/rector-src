<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;
use Rector\Naming\Rector\ClassMethod\RenameParamToMatchTypeRector;

return static function (RectorConfig $rectorConfig): void {
    $rectorConfig->rule(RenameParamToMatchTypeRector::class);
};
