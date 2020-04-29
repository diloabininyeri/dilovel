<?php

Router::get('/home/ff/:id',fn()=>router('deneme',['id'=>14]))->name('deneme')->middleware('mid','mid2');


Router::get('deneme/:id',static function (){

    $id= request()->get('id');
    return router('deneme',['id'=>$id]);

});
Router::get('/fefe','controller@dsffssffs')->name('deneme1')->middleware('mid','mid2');
Router::get('/news/id','Controller@meth')->name('fgd')->middleware('mid','mid2');
Router::get('/news/id/haber','Controlljjjjjjjjjer@meth')->name('fgd')->middleware('mid','mid2');



