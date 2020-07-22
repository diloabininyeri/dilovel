<?php

Route::get('/', fn () => view('index'))->name('index');

Route::get('form', fn () =>view('form'))->name('dd');
Route::post('dene', 'Controller@index')->name('form.post');


Route::get('/home/:id', fn () => 'strinh olandan ')->name('home');

Route::get('example', fn () => 'user cant acces this callback due to middleware')->middleware('example');


Route::get('deneme/int:id/string:name/:any/date:date', static function () {
    $id = request()->get('id');
    return route(
        'asd',
        [
            'int:id' => $id,
            'string:name' => request()->get('name'),
            ':any' => request()->get('any'),
            'date:date' => request()->get('date')
        ]
    );
})->name('asd');
Route::get('/fefe', 'Controller@index');
Route::get('/asd', 'Controller@index')->name('asd')->middleware('example');
Route::get('/news/int:id', 'Controller@meth')->name('fgd')->middleware('mid', 'mid2');
Route::get('/news/id/haber', 'Controlljjjjjjjjjer@meth')->name('fgd')->middleware('mid', 'mid2');
