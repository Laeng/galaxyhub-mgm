<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Ban Database Migrations
    |--------------------------------------------------------------------------
    |
    | Determine if default package migrations should be registered.
    | Set value to `false` when using customized migrations.
    |
    */

    'load_default_migrations' => false,

    /*
    |---------------------------------------------------------------------------
    | URL to redirect banned user to
    |---------------------------------------------------------------------------
    |
    | Provide a url, this is where a banned user will be redirected to
    | by the middleware.
    |
    | For example:
    |
    | 'redirect_url' => route('banned.user'),
    |
    | or
    |
    | 'redirect_url' => '/user/banned',
    |
    | Leaving the value as null will result in a redirect "back".
    |
    */

    'redirect_url' => '/app/account/suspended',

];
