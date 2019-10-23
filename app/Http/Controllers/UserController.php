<?php

namespace App\Http\Controllers;

use App\Jobs\RandInsert;
use Illuminate\Http\Request;
use App\Interfaces\AgeHandler;
use Illuminate\Support\Facades\Redis;

class UserController extends Controller
{
    public function test(AgeHandler $age)
    {
        //dd(app());
        return $age->saySelfAge();
    }

    public function redisSet($key,$value){
        if(Redis::set($key,$value)){
            return "set--- key:".$key."---value:".$value;
        } else {
            return "啥也没干";
        }
    }

    public function redisGet($key){
        return Redis::get($key);
    }

    public function queue(){
        for($i = 0;$i < 5;$i++){
            RandInsert::dispatch()->onConnection('l6t_queue')->onQueue('rand_insert');
        }
    }
}
