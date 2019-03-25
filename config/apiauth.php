<?php

return [
    'services' => [
        
        'REMOTE_APP' => [
            'token' => env("REMOTE_APP_TOKEN", "somedefaultvalue"),
            'tokenName' => 'api_token',

            'allowJsonToken' => true,
            'allowBearerToken' => true,
            'allowRequestToken' => true,
        ]
    ],
];
