<?php

return [
    'log_level' => env('KLEE_LOG_LEVEL', 'error'),
    'log_env'   => env('KLEE_LOG_ENV', 'development,staging'),
    'endpoint'  => env('KLEE_ENDPOINT', 'https://klee.phemanga.com/api/bugs'),
    'token'     => env('KLEE_AUTH_TOKEN', '')
];