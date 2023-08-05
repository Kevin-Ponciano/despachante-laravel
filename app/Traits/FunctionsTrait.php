<?php

namespace App\Traits;

trait FunctionsTrait
{
    public function regexMoney($number)
    {
        return strtr($number, [
            '.' => '',
            ',' => '.',
        ]);
    }

    public function regexMoneyToView($number)
    {
        return strtr($number, [
            '.' => ',',
        ]);
    }

    public function onlyNumbers($string)
    {
        return preg_replace('/[^0-9]/', '', $string);
    }
}
