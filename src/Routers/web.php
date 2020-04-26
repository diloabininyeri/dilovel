<?php


Router::get('deneme', 'Deneme@index')->name('deneme');

Router::get('controller', 'Controller@index')->name('controller');

Router::get('dilo/gg',function (){
    return 'merhabaa';
})->name('ddd');

Router::group(['namespace' => 'Payment'], static function () {

    Router::get('odeme','Pay@make');

});


