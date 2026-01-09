<?php

namespace Core\Entities;

require_once(__DIR__ . DIRECTORY_SEPARATOR . '../lib/Str.php');
require_once(__DIR__ . DIRECTORY_SEPARATOR . '../lib/Arr.php');

use Core\Lib\Arr;
use Core\Lib\Str;

class Pet {
    
    protected string $species;
    protected string $race;
    protected string $name;
    protected array $characteristic;
    public bool $is_favorite = false;
    
    public function __construct(string $name, string $species, string $race, array|string $characteristic = [], bool $is_favorite = false) {
        $this->name = $name;
        $this->species = $species;
        $this->race = $race;
        $this->characteristic = (array) $characteristic;
        $this->is_favorite = $is_favorite;
    }
    
    public function getName() { return $this->name; }
    public function getSpecies(){ return $this->species; }
    public function getRace() { return $this->race; }
    public function getCharacteristic() { return $this->characteristic; }
    
    public function setName(string $name) { $this->name = $name; }
    public function setSpecies(string $species){ $this->species = $species; }
    public function setRace(string $race) { $this->race = $race; }
    public function setCharacteristic(array $characteristic) { $this->characteristic = $characteristic; }
    public function addCharacteristic(string $characteristic) { $this->characteristic[] = $characteristic; }
    
    public function count() {
        return new class($this) {
            public function __construct(private Pet $p) {}
            private function apply(string $method) {
                $m = trim($method);
                if (! method_exists(Pet::class, $m)) return null;
                
                $g = $this->p->{$m}();
                $g = Arr::flatten(is_array($g) ? $g : (array) $g);
                $r = [];
                foreach($g as $i) {
                    $r[] = [
                        'value' => $i,
                        'total' => mb_strlen($i)
                    ];
                }
                
                return $r;
            }
            
            public function name() { return $this->apply('getName'); }
            public function species() { return $this->apply('getSpecies'); }
            public function race() { return $this->apply('getRace'); }
            public function characteristic() { return $this->apply('getCharacteristic'); }
        };
    }
    
    public function isPalindrome(bool $case = false) {
        return new class($this, $case) {
            public function __construct(private Pet $p, private bool $case) {}
            
            private function apply(string $method) {
                $m = trim($method);
                if (! method_exists(Pet::class, $m)) return null;
                
                $g = $this->p->{$m}();
                $g = !$this->case ? strtolower($g) : $g;
                // $g = Arr::flatten(is_array($g) ? $g : (array) $g);
                // $r = [];
                // // foreach($g as $i) {
                // //     $r[] = [
                // //         'value' => $i,
                // //         'result' => Str::isPalindrome($i)
                // //     ];
                // // }
                
                $r = [
                    'value' => $g,
                    'result' => Str::isPalindrome($g)
                ];
                
                return $r;
            }
            
            public function name() { return $this->apply('getName'); }
            public function species() { return $this->apply('getSpecies'); }
            public function race() { return $this->apply('getRace'); }
            // public function characteristic() { return $this->apply('getCharacteristic'); }
        };
    }
    
    public function to_array() {
        return [
             'name' => $this->name,
             'species' => $this->species,
             'race' => $this->race,
             'characteristic' => $this->characteristic,
             'favorite' => $this->is_favorite
        ];
    }
}
