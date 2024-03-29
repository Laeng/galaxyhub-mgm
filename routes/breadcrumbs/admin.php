<?php

use Diglactic\Breadcrumbs\Breadcrumbs;
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;

Breadcrumbs::for('app.admin', function(BreadcrumbTrail $trail, string $title) {
    $trail->push('메인', route('app.index'));
    $trail->push('관리자 메뉴', route('admin.index'));
    $trail->push($title);
});

Breadcrumbs::for('app.admin.application', function(BreadcrumbTrail $trail, string $title) {
    $trail->push('메인', route('app.index'));
    $trail->push('관리자 메뉴', route('admin.index'));
    $trail->push('가입 신청자', route('admin.application.index'));
    $trail->push($title);
});

Breadcrumbs::for('app.admin.user', function(BreadcrumbTrail $trail, string $title) {
    $trail->push('메인', route('app.index'));
    $trail->push('관리자 메뉴', route('admin.index'));
    $trail->push('회원', route('admin.user.index'));
    $trail->push($title);
});


Breadcrumbs::for('app.admin.budget', function(BreadcrumbTrail $trail, string $title) {
    $trail->push('메인', route('app.index'));
    $trail->push('관리자 메뉴', route('admin.index'));
    $trail->push('예산', route('admin.index'));
    $trail->push($title);
});
