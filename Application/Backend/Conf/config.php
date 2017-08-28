<?php
return array(
    'URL_ROUTER_ON'   => true,
    'URL_MAP_RULES' => array(
        'auth/login' => 'Auth/login',
        'auth/logout' => 'Auth/logout',

        'app/view' => 'App/view',
        'app/create' => 'App/create',
        'app/order' => 'App/order',
        'app/data' => 'App/data',

        'account/profile' => 'Account/profile',

        'gateway/create' => 'Gateway/create',
        'gateway/view' => 'Gateway/view',
    ),
);