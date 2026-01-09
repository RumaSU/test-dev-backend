<?php

namespace Core\Lib;

class Str {
    
    public static function reverse(string $s) {
        $s = array_reverse(mb_str_split($s, 1));
        return implode('', $s);
    }
    
    public static function isPalindrome(string|array $s) {
        return $s == static::reverse($s);
    }
    
    public static function isAnagram(string $s1, string $s2) {
        if (mb_strlen($s1) != mb_strlen($s2)) {
            return false;
        }
        
        $a = mb_str_split($s1);
        $b = mb_str_split($s2);
        sort($a);
        sort($b);
        return $a === $b;
    }
    
    public static function htmlspecialchars(string|array $s) {
        if (!is_array($s)) {
            return htmlspecialchars($s, ENT_QUOTES, 'UTF-8');
        }
        
        foreach($s as &$i) {
            $i = static::htmlspecialchars($i);
        }
        
        return $s;
    }
}