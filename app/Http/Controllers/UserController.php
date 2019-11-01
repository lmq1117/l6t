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

    public function redisSet($key, $value)
    {
        if (Redis::set($key, $value)) {
            return "set--- key:" . $key . "---value:" . $value;
        } else {
            return "啥也没干";
        }
    }

    public function redisGet($key)
    {
        return Redis::get($key);
    }

    public function queue()
    {
        for ($i = 0; $i < 5000; $i++) {
            RandInsert::dispatch()->onConnection('l6t_queue')->onQueue('rand_insert');
        }
    }

    public function pipeline()
    {
        return debug_backtrace();
    }

    public function page(Request $request)
    {
        //$articles = Article::simplePaginate($request->get("page",15));
        //$articles = Article::where('id','>','6000000')->limit(15)->get();
        $page = $request->get('page', 1);
        $size = $request->get('size', 2);
        $save = 50100000;
        $add = Article::selectRaw('count(id) as addNum')->where('id','>',$save)->first()->addNum ?? 0;
        $total = $save + $add;
        dump($save);
        dd($add);
        $articles = Article::whereRaw("id <= (select max(id) from articles) - " . max($page - 1, 0) * $size)->limit($size)->orderBy('id', 'desc')->get();
        return view('article.list', ['articles' => $articles]);
        //return $articles;
    }

    public function po(Request $request)
    {
        //$articles = Article::simplePaginate($request->get("page",15));
        //$articles = Article::where('id','>','6000000')->limit(15)->get();
        $page = $request->get('page', 1);
        $size = $request->get('size', 2);
        $articles = Article::orderBy('id', 'desc')->offset(($page - 1) * $size)->limit($size)->orderBy('id', 'desc')->get();
        return view('article.list', ['articles' => $articles]);
        //return $articles;
    }

}
