# DILOVEL php framework 




```<?php
 
 Router::get('/', fn () => view('index'))->name('index');

 Router::auth('App\Application\Auth\Admin', 'isAuth', static function () {
     Router::get('admin', fn () =>env('REDIS_HOST'));
 });
```
#continues to develop


stay on at http://localhost



![stay at localhost](https://i.ibb.co/NSVRG18/carbon.png)

![](https://i.ibb.co/XCfRF09/carbon-1.png)

**mvc-hmvc components** 
###### -auth
>login logout register all automatically also have obverse that all it can management
###### -view cache 
>u can store your view on a cache just use view_cache function
###### -router
>advanced php router
###### -middleware
>http request management
###### -orm
>-pssql mysql mariadb
###### -migration
>create a table from terminal basically

###### -parallel queue(multi consumer)
>rabitmq
###### -policy
>management user permission easily 
###### -template engine
>blade template engine extra features
###### -mailing 
>swift mailing 
###### -Cache
>-redis<br>
>-memcached<br>
###### -concurrency 
>process fork
>multi thread 
>async etc
###### -request management
>-file <br>
>-sessions<br>
>-cookie<br>
>-url<br>
>-redirect<br>
>-device checks( as mobile etc)
###### -request validation
>validation form request and other all 
###### -sessions 
###### -flash sessions 
###### -flash sessions  errors
###### more ....



