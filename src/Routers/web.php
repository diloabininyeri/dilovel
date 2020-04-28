<?php

Router::get('/',fn()=>view('index'))->name('deneme')->middleware('mid','mid2');
Router::get('/fefe','controller@dsffssffs')->name('deneme1')->middleware('mid','mid2');
Router::get('/news/id','Controller@meth')->name('fgd')->middleware('mid','mid2');



