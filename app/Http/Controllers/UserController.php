<?php

namespace App\Http\Controllers;

use App\Article;
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
        for($i = 0;$i < 5000;$i++){
            RandInsert::dispatch()->onConnection('l6t_queue')->onQueue('rand_insert');
        }
    }

    public function pipeline(){
        return debug_backtrace();
    }

    public function page(Request $request){
        //$articles = Article::simplePaginate($request->get("page",15));
        //$articles = Article::where('id','>','6000000')->limit(15)->get();
        $page = $request->get('page',1);
        $size = $request->get('size',15);
        $articles = Article::whereRaw("id > (select max(id) from articles) - {$page}*")->orderBy('id','desc')->limit($size)->get();
        return $articles;
    }

}
