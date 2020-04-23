<?php


Router::get('haber/5', 'Deneme@index')->name('deneme');

Router::get('controller', 'Controller@index')->name('controller');

Router::get('berna/gg',function (){
    return 'merhabaa';
})->name('ddd');

Router::group(['namespace' => 'Payment'], static function () {

    Router::get('odeme','Pay@make');

});


