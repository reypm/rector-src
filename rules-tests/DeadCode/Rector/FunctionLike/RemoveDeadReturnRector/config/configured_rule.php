<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;
use Rector\DeadCode\Rector\FunctionLike\RemoveDeadReturnRector;

return static function (RectorConfig $rectorConfig): void {
    $rectorConfig->rule(RemoveDeadReturnRector::class);
};
