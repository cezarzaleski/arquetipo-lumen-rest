<?php

return [
    /*
     * Configs cache to doctrine
     * @see http://www.laraveldoctrine.org/docs/1.3/orm/lumen
     */
    'stores' => [
        'file' => [
            'driver' => 'file',
            'path'   => storage_path('framework/cache'),
        ],
    ],
    'prefix' => '_mmcore_',
    'default' => 'file',
];
