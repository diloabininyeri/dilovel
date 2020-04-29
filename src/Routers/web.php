<?php

Router::get('/home/ff/id',fn()=>router('deneme',['id'=>14]))->name('deneme')->middleware('mid','mid2');


Router::get('deneme/:id',static function (){

    return request()->get('id');

});
Router::get('/fefe','controller@dsffssffs')->name('deneme1')->middleware('mid','mid2');
Router::get('/news/5','Controller@meth')->name('fgd')->middleware('mid','mid2');
Router::get('/news/id/haber','Controlljjjjjjjjjer@meth')->name('fgd')->middleware('mid','mid2');



