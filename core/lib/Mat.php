<?php

namespace Core\Lib;

class Mat {
    
    public static function is_even(int $n) {
        return $n % 2 == 0;
    }
    
    public static function is_odd(int $n) {
        return !static::is_even($n);
    }
    
}