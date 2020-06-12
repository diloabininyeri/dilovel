<?php

Router::get('/', fn () => view('index'))->name('index');

Router::path('test');

Router::view('/view-test', 'index');



Router::auth('App\Application\Auth\Admin', 'isAuth', static function () {
    Router::get('admin', fn () =>env('REDIS_HOST'));
});

Router::auth('App\Application\Auth\Admin', 'isAuth')->path('admin.admin_test');
Router::auth('App\Application\Auth\Admin', 'isAuth')->path('nested.example');

Router::path('custom_router_for_from_path');
