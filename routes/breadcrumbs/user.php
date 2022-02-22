<?php

use Diglactic\Breadcrumbs\Breadcrumbs;
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;

Breadcrumbs::for('app', function(BreadcrumbTrail $trail, string $title) {
    $trail->push('MGM Lounge', route('app.index'));
    $trail->push($title);
});

Breadcrumbs::for('app.mission', function(BreadcrumbTrail $trail, string $title) {
    $trail->push('MGM Lounge', route('app.index'));
    $trail->push('미션', route('mission.list'));
    $trail->push($title);
});
