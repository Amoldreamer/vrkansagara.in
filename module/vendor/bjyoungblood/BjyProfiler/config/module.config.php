<?php
return array(
    'service_manager' => array(
        'factories' => array(
            'Laminas\Db\Adapter\Adapter' => 'BjyProfiler\Db\Adapter\ProfilingAdapterFactory'
        ),
    ),
);
