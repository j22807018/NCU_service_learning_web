<?php

return [
    'host_domain' => env('NETID_HOST_DOMAIN'),
    'prefix' => env('NETID_PREFIX'),
    'allowed_roles' => explode(',', env('NETID_ALLOWED_ROLES')),
];
