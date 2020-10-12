<?php

declare(strict_types=1);

use Laminas\Navigation\ConfigProvider;

return [
    'service_manager' => (new ConfigProvider())->getDependencyConfig(),
];
