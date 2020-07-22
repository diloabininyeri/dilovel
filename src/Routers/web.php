<?php

Router::get('/', fn () => view('index'))->name('index');



Router::get('router_test', fn () =>route('custom_name.test'));
Router::view('/view-test', 'index');

Router::post('deneme/', 'Deneme@index')->name('reg');

Router::post('upload', 'ImageFormHandleAndResizeTest@test')->name('test');
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


Router::path('test');

Router::group(['namespace' => 'Nested', 'name' => 'nested', 'middleware' => [],'prefix'=>'nested'], static function () {
    Router::get('/news', 'NestedTestController@index')->name('news');
    Router::get('/personel', fn () => 'fewfwfewfewf')->name('personel');
});

Router::get('gorup-out', fn () => __FUNCTION__);

Router::group(['namespace' => 'Other', 'name' => 'other', 'middleware' => ['example'],'prefix'=>'other/bar/'], static function () {
    Router::get('foo', 'Abs@index')->name('news');
    Router::get('/personel/foo', fn () => 'fewfwfewfewf')->name('personel');
});

Router::get('hass/hiss', fn () =>__FUNCTION__);

Router::prefix('Other', static function () {
    Router::get('prefix_test', 'Abs@index');
});

Router::middleware(['example'], static function () {
    Router::get('middleware_test', fn () =>route('middleware_test'))->name('middleware_test');
    Router::get('middleware_test1', fn () =>route('middleware_test'))->name('middleware_test1');
});


Router::get('prev_next_test', 'PrevNextTest@index');

Router::name('custom_name', static function () {
    Router::get('custom_name_test', fn () =>route('custom_name.test'))->name('test1');
    Router::get('custom_name_other', fn () =>route('custom_name.test_other'))->name('test_other');
});
