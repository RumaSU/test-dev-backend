<?php

namespace Core\Lib;

require_once(__DIR__ . DIRECTORY_SEPARATOR . 'Mat.php');
use Core\Lib\Mat;

class Arr {
    
    public static function flatten(array $arr) {
        $r = [];
        foreach($arr as $a) {
            if (is_array($a)) $r = array_merge($r, static::flatten($a));
            else $r[] = $a;
        }
        
        return $r;
    }
    
    public static function sum_number(array $arr) {
        $a = static::get_int($arr)->all();
        
        return [
            'number' => $a,
            'total' => array_sum($a)
        ];
    }
    
    public static function sum_even(array $arr) {
        $o = [];
        foreach($arr as $n) {
            if (is_int($n) && $n % 2 == 0) $o[] = $n;
        }
        
        return [
            'number' => $o,
            'total' => array_sum($o)
        ];
    }
    
    public static function sum_odd(array $arr) {
        $o = [];
        foreach($arr as $n) {
            if (is_int($n) && $n % 2 != 0) $o[] = $n;
        }
        
        return [
            'number' => $o,
            'total' => array_sum($o)
        ];
    }
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    public static function get_int(array $arr) {
        return new class($arr) {
            public function __construct(private array $arr) {}
            
            private function e_o(bool $even = true) {
                $o = [];
                $f = $even
                    ? fn ($n) => $n % 2 == 0
                    : fn ($n) => $n % 2 != 0;
                foreach($this->all() as $a) {
                    if ($f($a)) $o[] = $a;
                }
                
                return $o;
            }
            
            public function all() {
                $o = [];
                foreach($this->arr as $a) {
                    if (is_int($a)) $o[] = $a;
                }
                
                return $o;
            }
            
            public function even() { return $this->e_o(); }
            public function odd() { return $this->e_o(false); }
        };
    }
    
}