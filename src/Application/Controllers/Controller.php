<?php


namespace App\Application\Controllers;

use App\Application\Models\Users;
use App\Application\Request\TcNoVerifyRequest;
use App\Components\Cache\CacheFactory;
use App\Components\Cache\Memcache\Memcache;
use App\Components\Cache\Redis\Redis;
use App\Components\Cache\Redis\RedisClient;
use App\Components\Http\Http;
use Cache;
use Curl\Curl;

/**
 * Class Controller
 * @package App\Controllers
 */
class Controller
{
    public function index(TcNoVerifyRequest $request)
    {
        $users=Users::get();
        $obj=(object)['name'=>'dılo sürücü','surname'=>'dılo sürücü'];
        $users->insertNewItem($obj, 3);
        return $users;


        /*$user=new Users();
        $user->name = 'deneme';

        return  $user->save();

        return $user->lastInsertId();*/
        /*$http = new Http();
        $http->get('https://www.google.com/', [
            'q'=>'dılo surucu',
        ]);
        return $http->getResponse();*/


        /* $http = new Http();
         $http->post('https://www.example.com/login/', array(
             'username' => 'myusername',
             'password' => 'mypassword',
         ));

         $http->getResponse();*/

/*
        $redis->publish('deneme', 'merhaba dunya');

        return $redis->pipeline(function ($pipe) {
            $pipe->ping();
            $pipe->flushdb();
            $pipe->incrby('counter', 10);
            $pipe->incrby('counter', 30);
            $pipe->exists('counter');
            $pipe->get('counter');
            $pipe->mget('does_not_exist', 'counter');
        });
*/



        /**
         * simple factory cache
         */
        /*$cache=new CacheFactory('memcache');
        $memcache=$cache->getInstance();
        $memcache->set('name', 'from mmm');
        echo  $memcache->get('name');


        $cache=new CacheFactory('redis');
        $redis=$cache->getInstance();
        echo  $redis->get('name');*/


        /* $users= Users::where('id', 30, '>')->paginate(12);
         return view('paginate', compact('users'));*/
        /* return Mail::to('berxudar@gmail.com', static function (Mail $mail) {
             $mail->setSubject('title mail');
             $mail->setView(view('index'));
             $mail->setSender('dilsizkaval@windowslive.com');
         });*/

        /* return Mail::to('berxudar@gmail.com', new ExampleMailable('mail test subject'));

         Mail::to('berxudar@gmail.com', static function (Mail $mail) {
             $mail->setView(view('index'));
         });*/


        /* $mail=new Mail();
         $mail->setSubject('title mail');
         $mail->setTo('berxudar@gmail.com');
         $mail->setView(view('index'));
         $mail->setSender('dilsizkaval@windowslive.com');
         return $mail->send();*/


        /*$mapper = Arr::mapper(
            new ForExampleMapper(),
            array(
                ['id' => 12, 'name' => 'dılo sürücü'],
                ['id' => 14, 'name' => 'aysun kyacı'])
        );*/


        //App::addDeferObject(new ExampleShutdownListener());
        //return $request->is('mobile');
        //return user()->get();

        /*$mail=new Mail();
        $mail->setSubject('title mail');
        $mail->setTo('berxudar@gmail.com');
        $mail->attach(__FILE__);
        $mail->setBody('message content foo bar ');
        $mail->setFrom('dilsizkaval@windowslive.com');
        return $mail->send();

        $queue=new Queue('test');
        $queue->add(new SendEmail());
        $queue->add(new ExampleQueue('dılo sürücü'));*/


        //$user= $request->user()->get();
        // Auth::user()->isCanLogin('berxudar@gmail.com',1234567);
        //Auth::user()->login(Users::find(34));
        //Auth::user()->logout();
        //return Auth::user()->get();
    }
}
