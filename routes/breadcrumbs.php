<?php

use Diglactic\Breadcrumbs\Breadcrumbs;
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;

//ref: https://github.com/diglactic/laravel-breadcrumbs

/*
// Home
Breadcrumbs::for('home', function (BreadcrumbTrail $trail) {
    $trail->push('Home', route('home'));
});

// Home > Blog
Breadcrumbs::for('blog', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Blog', route('blog'));
});

// Home > Blog > [Category]
Breadcrumbs::for('category', function (BreadcrumbTrail $trail, $category) {
    $trail->parent('blog');
    $trail->push($category->title, route('category', $category));
});
*/

Breadcrumbs::for('Lounge', function(BreadcrumbTrail $trail) {
    $trail->push('MGM 라운지', route('auth.login'));
    $trail->push('미션', route('auth.login'));
    $trail->push('5월 14일 미션', route('auth.login'));
});

require_once __DIR__ . '/breadcrumbs/admin.php';
require_once __DIR__ . '/breadcrumbs/user.php';
