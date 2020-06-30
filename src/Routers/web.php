<?php

Router::get('/', fn () => view('index'))->name('index');

Router::path('test');

Router::view('/view-test', 'index');

Router::get('deneme/:id', 'Deneme@index')->name('deneme');

Router::post('upload', 'ImageFormHandleAndResizeTest@test')->name('test')->middleware('captcha');
Router::view('form', 'form')->name('form');

Router::get('fef', 1)->namespace('fefef');
Router::auth('App\Application\Auth\Admin', 'isAuth', static function () {
    Router::get('admin', fn () => env('REDIS_HOST'));
});

Router::auth('App\Application\Auth\Admin', 'isAuth')->path('admin.admin_test');
Router::auth('App\Application\Auth\Admin', 'isAuth')->path('nested.example');

Router::ip(['::1', 'localhost', '127.0.0.1'], static function () {
    Router::get('custom-area', fn () => 'custom area can pass with ip address');
});

Router::path('custom_router_for_from_path');


Router::group(['namespace' => 'Nested', 'name' => 'nested', 'middleware' => [],'prefix'=>'nested'], static function () {
    Router::get('/news', 'NestedTestController@index')->name('news');
    Router::get('/personel', fn () => 'fewfwfewfewf')->name('personel');
});

Router::get('gorup-out', fn () => __FUNCTION__);

Router::group(['namespace' => 'Other', 'name' => 'other', 'middleware' => [],'prefix'=>'other/bar/'], static function () {
    Router::get('foo', 'Abs@index')->name('news');
    Router::get('/personel/foo', fn () => 'fewfwfewfewf')->name('personel');
});

Router::get('hass/hiss', fn () =>__FUNCTION__);

Router::prefix('Other', static function () {
    Router::get('prefix_test', 'Abs@index');
});

Router::middleware(['guest'], static function () {
    Router::get('middleware_test', fn () =>router('middleware_test'))->name('middleware_test');
});


Router::name('custom_name', static function () {
    Router::get('custom_name_test', fn () =>router('custom_name.test'))->name('test');
    Router::get('custom_name_other', fn () =>router('custom_name.test_other'))->name('test_other');
});
