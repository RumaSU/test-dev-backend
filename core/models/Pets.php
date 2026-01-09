<?php

namespace Core\Models;

require_once( __DIR__ . DIRECTORY_SEPARATOR . '../entities/Pet.php');
require_once( __DIR__ . DIRECTORY_SEPARATOR . '../lib/Arr.php');

use Core\Entities\Pet;
use Core\Lib\Arr;

class Pets {
    
    /** @var array<Pet>  */
    protected array $pets = []; 
    
    public function __construct(Pet ...$pet) {
        $this->pets = $pet;
    }
    
    public function add(Pet $pet) {
        $this->pets[] = $pet;
    }
    
    public function delete() {
        return new class($this->pets) {
            public function __construct(private &$pets) {}
            
            private function apply(string $target, string $method, bool $all = false, bool $case = false) {
                if (!method_exists(Pet::class, $method)) return;
                
                $target = $case ? $target : strtolower($target);
                $match = fn(Pet $p) => $target === ($case ? $p->$method() : strtolower($p->$method()));
                
                if ($all) {
                    $this->pets = array_values(array_filter($this->pets, fn(Pet $p) => !$match($p)));
                } else {
                    $k = null;
                    // $k = array_find_key($this->pets, $c);
                    foreach($this->pets as $idx => $p) {
                        if ($match($p)) {
                            $k = $idx;
                            break;
                        }
                    }
                    
                    if ($k !== null) {
                        $this->index($k);
                    }
                }
            }
            
            public function index(int $idx) {
                if (isset($this->pets[$idx])) {
                    array_splice($this->pets, $idx, 1);
                }
            }
            
            public function name(string $name, bool $all = false, bool $case = false) {
                $this->apply($name, 'getName', $all, $case);
            }
            public function species(string $species, bool $all = false, bool $case = false) {
                $this->apply($species, 'getSpecies', $all, $case);
            }
            public function race(string $race, bool $all = false, bool $case = false) {
                $this->apply($race, 'getRace', $all, $case);
            }
            public function characteristic(array|string $characteristic, bool $all = false, bool $case = false) {
                $target = (array) $characteristic;
                $target = array_map(fn($i) => $case ? $i : strtolower($i), $target);
                
                $k = [];
                foreach($this->pets as $idx => $p) {
                    $c = array_values($p->getCharacteristic());
                    if (! $case) $c = array_map('strtolower', $c);
                    
                    if(! empty(array_intersect($target, $c))) {
                        $k[] = $idx;
                        if (! $all) break;
                    }
                }
                
                if (empty($k)) return;
                
                $k = array_unique($k);
                $this->pets = array_values(array_filter($this->pets, fn($idx) => !in_array($idx, $k), ARRAY_FILTER_USE_KEY));
            }
        };
    }
    
    public function find(string $target, bool $all = false, bool $as_array = false, bool $case = false) {
        return new class($this->pets, $target, $all, $as_array, $case) {
            public function __construct(private &$pets, private $target, private bool $all = false, private bool $as_array, private bool $case = false) {}
            
            private function apply(string $method): ?array {
                if (!method_exists(Pet::class, $method)) return null;
                
                $target = $this->case ? $this->target : strtolower($this->target);
                $match = fn(Pet $p) => $target === ($this->case ? $p->$method() : strtolower($p->$method()));
                
                $v = array_values(array_filter($this->pets, fn(Pet $p) => $match($p)));
                if ($this->as_array) $v = array_map(fn(pet $p) => $p->to_array(), $this->pets);
                
                return $v;
            }
            public function name(): Pet|array|null {
                $s = $this->apply('getName');
                return $this->all ? $s : ($s[0] ?? null);
            }
            public function species(): Pet|array|null {
                $s = $this->apply('getSpecies');
                return $this->all ? $s : ($s[0] ?? null);
            }
            public function race(): Pet|array|null {
                $s = $this->apply('getRace');
                return $this->all ? $s : ($s[0] ?? null);
            }
        };
    }
    
    public function change() {
        return new class($this->pets) {
            public function __construct(private &$pets) {}
            
            private function apply(string $from, string $to, string $method, bool $all = false, bool $case = false) {
                $method = trim($method);
                
                $get = 'get' . ucfirst($method);
                $set = 'set' . ucfirst($method);
                if (! method_exists(Pet::class, $get) || 
                    ! method_exists(Pet::class, $set)   ) return;
                
                $target = $case ? $from : strtolower($from);
                
                foreach($this->pets as &$p) {
                    $c = $case ? $p->{$get}() : strtolower($p->{$get}());
                    
                    if ($c == $target) {
                        $p->{$set}($to);
                        if (!$all) break;
                    }
                }
            }
            
            public function name(string $from, string $to, bool $all = false, bool $case = false) {
                $this->apply($from, $to, 'name', $all, $case);
            }
            public function species(string $from, string $to, bool $all = false, bool $case = false) {
                $this->apply($from, $to, 'species', $all, $case);
            }
            public function race(string $from, string $to, bool $all = false, bool $case = false) {
                $this->apply($from, $to, 'race', $all, $case);
            }
        };
    }
    
    public function get() {
        return new PetsGet($this->pets);
    }
    
    public function count() {
        return count($this->pets);
    }
    
}


class PetsGet {
    
    /** @var array<Pet> */
    private array $pets = []; 
    
    
    public function __construct($pets) {
        $this->pets = $pets;
    }
    public function all(bool $as_array = false) {
        return array_map(fn(Pet $p) => $as_array ? $p->to_array() : $p, $this->pets);
    }
    
    public function favorites(bool $ascend = true, bool $as_array = false) {
        $list = array_filter($this->pets, fn(Pet $p) => $p->is_favorite);
        usort($list, fn(Pet $a, Pet $b) => $ascend 
            ? strcmp($a->getName(), $b->getName()) 
            : strcmp($b->getName(), $a->getName())
        );
        
        return array_map(fn(Pet $p) => $as_array ? $p->to_array() : $p, $list);
    }
     
    public function count() {
        return new class($this) {
            
            /** @var PetsGet */
            protected $p;
            
            public function __construct($p) { $this->p = $p; }
            private function apply(string $method) {
                $m = strtolower(trim($method));
                $w = ['name', 'species', 'race', 'characteristic', 'favorite'];
                if (! in_array($m, $w)) return [];
                
                $g = $this->p->all(true);
                $r = array_map(fn($i) => $i[$m], $g);
                $r = is_array($r[0]) ? Arr::flatten($r) : $r;
                return array_unique($r);
            }
            
            public function name() { return count($this->apply('name')); }
            public function species() { return count($this->apply('species')); }
            public function race() { return count($this->apply('race')); }
            public function characteristic() { return count($this->apply('characteristic')); }
            public function favorite() { return count($this->apply('favorite')); }
        };
    }
    
    public function total() {
        return new class($this) {
            /** @var PetsGet */
            private $p;
            public function __construct($p) {$this->p = $p;}
            
            private function run(string $method) {
                $m = trim($method);
                $q = $this->p->by();
                if (! method_exists($q, $m)) return ['total' => 0, 'type' => $m, 'list' => []];
                
                $d = array_filter($q->{$m}(), fn($v) => is_string($v) || is_int($v));
                $arr = array_count_values($d);
                
                $t = 0;
                $list = array_map(function($ty, $tt) use (&$t) {
                    $t += $tt;
                    return [
                        'value' => $ty,
                        'total' => $tt
                    ];
                }, array_keys($arr), $arr);
                
                return [
                    'total' => $t,
                    'type' => $m,
                    'list' => $list
                ];
            }
            
            public function names() { return $this->run('names'); }
            public function species() { return $this->run('species'); }
            public function races() { return $this->run('races'); }
            public function characteristic() { return $this->run('characteristic'); }
        };
    }
    
    public function by(bool $unique = false) {
        return new class($this->pets, $unique) {
            /** @var array<Pet> $p */
            public function __construct(private $p, private $u) {}
            
            private function run(string $method) {
                if (! method_exists(Pet::class, $method)) return [];
                $r = array_map(fn(Pet $p) => $p->{$method}(), $this->p);
                $s = Arr::flatten($r);
                if ($method === 'getCharacteristic') $s = array_filter($s, fn($a) => !empty($a));
                
                return $this->u
                    ? array_unique($s)
                    : $s;
            }
            
            public function names() { return $this->run('getName'); }
            public function species() { return $this->run('getSpecies'); }
            public function races() { return $this->run('getRace'); }
            public function characteristic() { return $this->run('getCharacteristic'); }
        };
    }
    
    public function palindrome(bool $case = false) {
        return new class($this->pets, $case) {
            /** @var array<Pet> $p */
            public function __construct(private $p, private bool $case) {}
            
            
            private function apply(string $method) {
                
                $m = trim($method);
                $c = $this->p[0]->isPalindrome($this->case);
                if (! method_exists($c, $m)) return ['value' => 0, 'result' => null, 'length' => 0];
                
                $gV = 'get' . ucfirst($m);
                $r = array_map( fn(Pet $p) => array_merge($p->isPalindrome($this->case)->{$m}(), ['length' => strlen($p->{$gV}())] ), $this->p);
                
                return $r;
            }
            
            public function names() { return $this->apply('name'); }
            public function species() { return $this->apply('species'); }
            public function races() { return $this->apply('race'); }
        };
        
    }
    
}