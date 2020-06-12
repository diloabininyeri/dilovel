<?php

Router::get('/', fn () => view('index'))->name('index');

Router::get('form', fn () =>view('form'))->name('dd');
Router::post('dene', 'Controller@index')->name('form.post');


Router::get('/home/:id', fn () => 'strinh olandan ')->name('home');

Router::get('example', fn () => 'user cant acces this callback due to middleware')->middleware('example');


Router::get('deneme/int:id/string:name/:any/date:date', static function () {
    $id = request()->get('id');
    return router(
        'asd',
        [
            'int:id' => $id,
            'string:name' => request()->get('name'),
            ':any' => request()->get('any'),
            'date:date' => request()->get('date')
        ]
    );
})->name('asd');
Router::get('/fefe', 'Controller@index');
Router::get('/asd', 'Controller@index')->name('asd')->middleware('example');
Router::get('/news/int:id', 'Controller@meth')->name('fgd')->middleware('mid', 'mid2');
Router::get('/news/id/haber', 'Controlljjjjjjjjjer@meth')->name('fgd')->middleware('mid', 'mid2');


Router::auth('App\Application\Auth\Admin', 'isAuth', static function () {
    Router::get('admin', fn () =>env('REDIS_HOST'));
});

Router::auth('App\Application\Auth\Admin', 'isAuth')->path('admin');

Router::auth('App\Application\Auth\Admin', 'isAuth')->path('nested.example');
