<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;
use Rector\Php55\Rector\FuncCall\PregReplaceEModifierRector;

return static function (RectorConfig $rectorConfig): void {
    $rectorConfig->rule(PregReplaceEModifierRector::class);
};
