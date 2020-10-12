<?php

return [
    'service_manager' => [
        'factories' => [
            'Laminas\Db\Adapter\Adapter' => 'BjyProfiler\Db\Adapter\ProfilingAdapterFactory'
        ],
    ],
];
