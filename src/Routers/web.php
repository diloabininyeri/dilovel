<?php

Router::get('/',function (){
     $array=[1,2,3];
     return view('index',compact('array'));
});

Router::get('deneme', 'Deneme@index')->name('deneme');

Router::get('controller', 'Controller@index')->name('controller');

Router::get('dilo/gg',function (){
})->name('ddd');

Router::group(['namespace' => 'Payment'], static function () {

    Router::get('odeme','Pay@make');

});

