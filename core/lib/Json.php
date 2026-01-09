<?php

namespace Core\Lib;

use SplFileInfo;
use JsonException;
use RuntimeException;

class Json {
    
    public static function file() {
        return new JsonFile();
    }
    
    public static function validate($values, int $depth = 512, int $flags = 0) {
        if (! is_string($values)) {
            return false;
        }
        
        if (PHP_VERSION_ID >= 80300) {
            return json_validate($values, $depth, $flags);
        }
        
        try {
            json_decode($values, false, $depth, $flags | JSON_THROW_ON_ERROR);
            return true;
        } catch (JsonException $e) {
            return false;
        }
        
    }
    
    public static function decode(string $json, bool $assoc = true, int $depth = 512, int $flags = 0){
        $result = json_decode($json, $assoc, $depth, $flags);
        if (json_last_error() !== JSON_ERROR_NONE) {
            return null;
        }
        return $result;
    }
    
    public static function encode(mixed $data, int $flags = JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES, int $depth = 512) {
        $json = json_encode($data, $flags, $depth);
        if (json_last_error() !== JSON_ERROR_NONE) {
            return false;
        }
        return $json;
    }
    
    
    public static function is_encodable(mixed $data): bool
    {
        try {
            // Coba encode tanpa flags khusus, menggunakan fungsi encode yang sudah ada
            static::encode($data, 0); 
            return true;
        } catch (RuntimeException $e) {
            // Jika RuntimeException (dari json_encode error) dilempar, berarti tidak encodable
            return false;
        }
    }
}


class JsonFile {
    
    protected const ACCEPT_MIME = [
        'application/json',
        'text/json', 
        'text/x-json',
    ];
    
    protected const MAX_FILE = 4 * 1024 * 1024;
    public function extract(string|SplFileInfo $file, bool|null $associative = null, int $depth = 512, int $flags = 0, bool $ignore_size = false) {
        if (is_string($file)) {
            if (! file_exists($file)) return null;
            $file = new SplFileInfo($file);
        }
        
        if (! in_array(mime_content_type($file->getPathname()), static::ACCEPT_MIME)) return null;
        if (! $ignore_size && ($file->getSize() > static::MAX_FILE)) return null;
        
        $json = json_decode(file_get_contents($file), $associative, $depth, $flags);
        if (json_last_error() !== JSON_ERROR_NONE) return null;
        
        return $json;
    }
    
}