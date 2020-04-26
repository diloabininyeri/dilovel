<?php

Router::get('/',fn()=>view('index'));

Router::get('deneme', 'Deneme@index')->name('deneme');

Router::get('controller', 'Controller@index')->name('controller');

Router::get('dilo/gg',function (){
})->name('ddd');

Router::group(['namespace' => 'Payment'], static function () {

    Router::get('odeme','Pay@make');

});

