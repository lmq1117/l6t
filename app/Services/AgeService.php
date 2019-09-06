<?php

namespace App\Services;


use App\Interfaces\AgeHandler;

class AgeService implements AgeHandler
{
    public $trueSex;

    public function __construct($sex)
    {
        $this->trueSex = $sex;
    }

    public function saySelfAge()
    {
        if ($this->trueSex == 1) {
            $s = "男";
            $age = 30;
        } else {
            $s = "女";
            $age = 18;
        }
        return "==".$s."==".$age."=====";
    }
}
