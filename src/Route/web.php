<?php

Route::get('/', fn () => view('index'))->name('index');



Route::get('throttle', fn () =>'hello')->middleware('throttle');


Route::get('router_test', fn () =>route('custom_name.test'));
Route::view('/view-test', 'index');

Route::post('deneme/', 'Deneme@index')->name('reg');
Route::get('deneme/', 'Deneme@index')->name('reg');

Route::post('upload', 'ImageFormHandleAndResizeTest@test')->name('test');
Route::view('form', 'form')->name('form');

Route::get('fef', 1)->namespace('fefef');
Route::auth('App\Application\Auth\Admin', 'isAuth', static function () {
    Route::get('admin', fn () => env('REDIS_HOST'));
});

Route::auth('App\Application\Auth\Admin', 'isAuth')->path('admin.admin_test');
Route::auth('App\Application\Auth\Admin', 'isAuth')->path('nested.example');

Route::ip(['::1', 'localhost', '127.0.0.1'], static function () {
    Route::get('custom-area', fn () => 'custom area can pass with ip address');
});


Route::path('test');

Route::group(['namespace' => 'Nested', 'name' => 'nested', 'middleware' => [],'prefix'=>'nested'], static function () {
    Route::get('/news', 'NestedTestController@index')->name('news');
    Route::get('/personel', fn () => 'fewfwfewfewf')->name('personel');
});

Route::get('gorup-out', fn () => __FUNCTION__);

Route::group(['namespace' => 'Other', 'name' => 'other', 'middleware' => ['example'],'prefix'=>'other/bar/'], static function () {
    Route::get('foo', 'Abs@index')->name('news');
    Route::get('/personel/foo', fn () => 'fewfwfewfewf')->name('personel');
});

Route::get('hass/hiss', fn () =>__FUNCTION__);

Route::prefix('Other', static function () {
    Route::get('prefix_test', 'Abs@index');
});

Route::middleware(['example'], static function () {
    Route::get('middleware_test', fn () =>route('middleware_test'))->name('middleware_test');
    Route::get('middleware_test1', fn () =>route('middleware_test'))->name('middleware_test1');
});


Route::get('prev_next_test', 'PrevNextTest@index');

Route::name('custom_name', static function () {
    Route::get('custom_name_test', fn () =>route('custom_name.test'))->name('test1');
    Route::get('custom_name_other', fn () =>route('custom_name.test_other'))->name('test_other');
});
