<?php

return [
    'local' => [
        'type' => 'Local',
        'root' => getenv('local_root'),
    ],
    'dropbox' => [
        'type' => 'Dropbox',
        'token' => getenv('dropbox_token'),
        'key' => getenv('dropbox_key'),
        'secret' => getenv('dropbox_secret'),
        'app' => 'PROPAR Backup',
        'root' => '/',
    ],
];
