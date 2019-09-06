<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Interfaces\AgeHandler;

class UserController extends Controller
{
    public function test(AgeHandler $age)
    {
        //dd(app());
        return $age->saySelfAge();
    }
}
