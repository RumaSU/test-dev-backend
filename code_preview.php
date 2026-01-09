<?php


$code1 = "
<?php
    \$esa = new Pets(
        new Pet('Otto', 'Anjing', 'Golden Retriever', ['Energik', 'Senang bermain bola'], true), 
        new Pet('Max', 'Anjing', 'Siberian Husky', ['Bulu lebat', 'Mata biru'], true),
        new Pet('Bob', 'Anjing', 'Beagle', ['Ceria', 'Aktif mengajak bermain di taman']),
        new Pet('Luna', 'Kucing', 'Persia', ['Anggun', 'Manja'], true),
        new Pet('Milo', 'Kucing', 'British Short', ['Cerdas', 'Aktif'], true),
        new Pet('Nana', 'Ikan', 'Koi', ['Indah']),
        new Pet('Goldie', 'Ikan', 'Mas', ['Warna Cerah']),
    );
    ";
$code2 = "
<?php
    \$esa->add(new Pet('Rino', 'Badak', 'Badak Jawa', 'Pekerja Keras', true));
";
    
$code3 = "
<?php
    \$esa->get()->favorites(true, true);
    
    Pets // Core\Models\Pets
    public function get() {
        return new PetsGet(\$this->pets);
    }
    
    PetsGet // Core\Models\Pets
    public function favorites(bool \$ascend = true, bool \$as_array = false) {
        \$list = array_filter(\$this->pets, fn(Pet \$p) => \$p->is_favorite);
        usort(\$list, fn(Pet \$a, Pet \$b) => \$ascend 
            ? strcmp(\$a->getName(), \$b->getName()) 
            : strcmp(\$b->getName(), \$a->getName())
        );
        
        return array_map(fn(Pet \$p) => \$as_array ? \$p->to_array() : \$p, \$list);
    }
";
    
$code4 = "
<?php
    \$esa->change()->race('Persia', 'Maine Coon');
    \$q4 = \$esa->get()->all(true);
    
    Pets // Core\Models\Pets
    public function change() {
        return new class(\$this->pets) {
            public function __construct(private &\$pets) {}
            
            private function apply(string \$from, string \$to, string \$method, bool \$all = false, bool \$case = false) {
                \$method = trim(\$method);
                
                \$get = 'get' . ucfirst(\$method);
                \$set = 'set' . ucfirst(\$method);
                if (! method_exists(Pet::class, \$get) || 
                    ! method_exists(Pet::class, \$set)   ) return;
                
                \$target = \$case ? \$from : strtolower(\$from);
                
                foreach(\$this->pets as &\$p) {
                    \$c = \$case ? \$p->{\$get}() : strtolower(\$p->{\$get}());
                    
                    if (\$c == \$target) {
                        \$p->{\$set}(\$to);
                        if (!\$all) break;
                    }
                }
            }
            
            public function species(string \$from, string \$to, bool \$all = false, bool \$case = false) {
                \$this->apply(\$from, \$to, 'species', \$all, \$case);
            }
            // ...
        };
    }
";

$code5 = "
<?php
    \$q5 = \$esa->get()->total()->species();
    
    Pets // Core\Models\Pets
    public function get() {
        return new PetsGet(\$this->pets);
    }
    
    PetsGet // Core\Models\Pets
    public function total() {
        return new class(\$this) {
            /** @var PetsGet */
            private \$p;
            public function __construct(\$p) {\$this->p = \$p;}
            
            private function run(string \$method) {
                \$m = trim(\$method);
                \$q = \$this->p->by();
                if (! method_exists(\$q, \$m)) return ['total' => 0, 'type' => \$m, 'list' => []];
                
                \$d = array_filter(\$q->{\$m}(), fn(\$v) => is_string(\$v) || is_int(\$v));
                \$arr = array_count_values(\$d);
                
                \$t = 0;
                \$list = array_map(function(\$ty, \$tt) use (&\$t) {
                    \$t += \$tt;
                    return [
                        'value' => \$ty,
                        'total' => \$tt
                    ];
                }, array_keys(\$arr), \$arr);
                
                return [
                    'total' => \$t,
                    'type' => \$m,
                    'list' => \$list
                ];
            }
            
            public function species() { return \$this->run('species'); }
            // ...
        };
    }    
";

$code6 = "
<?php
    \$q6 = \$esa->get()->palindrome()->names();
    
    Pets // Core\Models\Pets
    public function get() {
        return new PetsGet(\$this->pets);
    }
        
    PetsGet // Core\Models\Pets
    public function palindrome(bool \$case = false) {
        return new class(\$this->pets, \$case) {
            /** @var array<Pet> \$p */
            public function __construct(private \$p, private bool \$case) {}
            
            
            private function apply(string \$method) {
                
                \$m = trim(\$method);
                \$c = \$this->p[0]->isPalindrome(\$this->case);
                if (! method_exists(\$c, \$m)) return ['value' => 0, 'result' => null, 'length' => 0];
                
                \$gV = 'get' . ucfirst(\$m);
                \$r = array_map( fn(Pet \$p) => array_merge(\$p->isPalindrome(\$this->case)->{\$m}(), ['length' => strlen(\$p->{\$gV}())] ), \$this->p);
                
                return \$r;
            }
            
            public function names() { return \$this->apply('name'); }
            // ...
        };
        
    }

";

$code7 = "
<?php
    \$n = [15,18,3,9,6,2,12,14];
    \$q7 = Arr::sum_even(\$n); 
    
    Arr // Core\Lib\Arr
    public static function sum_even(array \$arr) {
        \$o = [];
        foreach(\$arr as \$n) {
            if (is_int(\$n) && \$n % 2 == 0) \$o[] = \$n;
        }
        
        return [
            'number' => \$o,
            'total' => array_sum(\$o)
        ];
    }
    
";

$code8 = "
<?php
    \$s = [
        ['education', 'ducatione'],
        ['kasur', 'rusak'],
        ['kasur', 'rusaa'],
        ['lapar', 'rappa'],
        ['makan', 'namak'],
    ];
    foreach(\$s as &\$i) {
        \$i[] = Str::isAnagram(\$i[0], \$i[1]); 
    }
    \$q8 = \$s;
    
    Str // Core\Lib\Str
    public static function isAnagram(string \$s1, string \$s2) {
        if (mb_strlen(\$s1) != mb_strlen(\$s2)) {
            return false;
        }
        
        \$a = mb_str_split(\$s1);
        \$b = mb_str_split(\$s2);
        sort(\$a);
        sort(\$b);
        return \$a === \$b;
    }
";

$code9 = "
<?php
    \$path = __DIR__ . DIRECTORY_SEPARATOR . 'assets/json/case.json';
    \$data = Json::file()->extract(\$path, true);
    \$data_agg = Cattegory::aggregator(\$data['data']);
    \$q9 = \$data_agg;
    
    Json // Core\Lib\Json
    public static function file() {
        return new JsonFile();
    }
        
    JsonFile //Core\Lib\Json
    public function extract(string|SplFileInfo \$file, bool|null \$associative = null, int \$depth = 512, int \$flags = 0, bool \$ignore_size = false) {
        if (is_string(\$file)) {
            if (! file_exists(\$file)) return null;
            \$file = new SplFileInfo(\$file);
        }
        
        if (! in_array(mime_content_type(\$file->getPathname()), static::ACCEPT_MIME)) return null;
        if (! \$ignore_size && (\$file->getSize() > static::MAX_FILE)) return null;
        
        \$json = json_decode(file_get_contents(\$file), \$associative, \$depth, \$flags);
        if (json_last_error() !== JSON_ERROR_NONE) return null;
        
        return \$json;
    }
    

";










// $q6 = $esa->get()->palindrome()->names();




