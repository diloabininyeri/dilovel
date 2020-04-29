<?php

Router::get('/home/:id',fn()=>router('deneme',['id'=>14]))->name('deneme')->middleware('mid','mid2');
Router::get('/home/int:id',fn()=>'int olandan ');


Router::get('deneme/int:id',static function (){

    $id= request()->get('id');
    return router('asd',['id'=>$id]);

})->name('asd');
Router::get('/fefe','controller@dsffssffs')->name('deneme1')->middleware('mid','mid2');
Router::get('/news/id','Controller@meth')->name('fgd')->middleware('mid','mid2');
Router::get('/news/id/haber','Controlljjjjjjjjjer@meth')->name('fgd')->middleware('mid','mid2');



