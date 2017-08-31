<?php
return array(
    'URL_ROUTER_ON'   => true,
    'URL_MAP_RULES' => array(
        'auth/login' => 'Auth/login',
        'auth/logout' => 'Auth/logout',

        'app/view' => 'App/view',
        'app/create' => 'App/edit?action=create',
        'app/edit' => 'App/edit',
        'app/order' => 'App/order',
        'app/data' => 'App/data',

        'account/profile' => 'Account/profile',

        'gateway/edit' => 'Gateway/edit',
        'gateway/view' => 'Gateway/view',
    ),
);