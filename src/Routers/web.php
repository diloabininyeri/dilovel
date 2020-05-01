<?php

Router::get('/', fn() => view('index'));

Router::get('form', 'ff@ff')->middleware('example')->authorize(['App\Routers\Authorize\RouterAuthorizeExample', 'isAuthorize']);

Router::get('/home/:id', fn() => 'strinh olandan ')->name('home');

Router::get('example', fn() => 'user cant acces this callback due to middleware')->middleware('example');


Router::get('deneme/int:id/string:name/:any/date:date', static function () {

    $id = request()->get('id');
    return router('asd',
        [
            'int:id' => $id,
            'string:name' => request()->get('name'),
            ':any' => request()->get('any'),
            'date:date' => request()->get('date')
        ]);

})->name('asd');
Router::get('/fefe', 'Deneme@index')->name('deneme')->middleware('name');
Router::get('/news/int:id', 'Controller@meth')->name('fgd')->middleware('mid', 'mid2');
Router::get('/news/id/haber', 'Controlljjjjjjjjjer@meth')->name('fgd')->middleware('mid', 'mid2');


Router::auth('App\Application\Auth\RouterAuth','isAuth',static function () {

    Router::get('aslan',fn()=>'denemememeee');
});


