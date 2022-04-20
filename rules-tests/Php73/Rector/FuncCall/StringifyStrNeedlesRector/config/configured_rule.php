<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;
use Rector\Php73\Rector\FuncCall\StringifyStrNeedlesRector;

return static function (RectorConfig $rectorConfig): void {
    $rectorConfig->rule(StringifyStrNeedlesRector::class);
};
