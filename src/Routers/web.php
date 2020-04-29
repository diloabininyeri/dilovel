<?php

Router::get('/home/int:id',fn()=>router('deneme',['int:id'=>14]))->name('deneme')->middleware('must_be_int');
Router::get('/home/string:id',fn()=>'strinh olandan ');


Router::get('deneme/int:id/string:name/:any/date:date',static function (){

    $id= request()->get('id');
    return router('asd',
        [
            'int:id'=>$id,
            'string:name'=>request()->get('name'),
            ':any'=>request()->get('any'),
            'date:date'=>request()->get('date')
        ]);

})->name('asd');
Router::get('/fefe','controller@dsffssffs')->name('deneme1')->middleware('mid','mid2');
Router::get('/news/int:id','Controller@meth')->name('fgd')->middleware('mid','mid2');
Router::get('/news/id/haber','Controlljjjjjjjjjer@meth')->name('fgd')->middleware('mid','mid2');



