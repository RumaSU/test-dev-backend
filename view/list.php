<?php

function view_list(array $list, bool $must_key = false, int $depth = 0) {
    $ul = '';
    
    $c = function($item, $key) use ($must_key, $depth) {
        $key = is_string($key) ? ucfirst($key) : ($must_key ? 'List' : null);
        $o = '';
        if (is_array($item)) {
            if ($must_key || is_string($key)) $o .= "<p class='text-gray-700'>• {$key} : </p>";
            $o .= view_list($item, $must_key, $depth+1);
        } else {
            $i = $must_key || is_string($key) ? "{$key} : " : "";
            $item = is_bool($item)
                ? ($item ? "✔" : "❌")
                : $item;
            $s = is_bool($item) 
                ? ($item ? 'text-green-600 font-semibold' : 'text-red-600 font-semibold') 
                : '';
            $o .= "<p class='text-gray-800 {$s}'>• {$i} {$item}</p>";
        }
        
        return $o;
    };
    
    foreach($list as $k => $li) {
        $content = $c($li, $k);
        
        $ul .= "<li class='mb-1'>{$content}</li>";
    }
    $indent = $depth ? 'px-4 py-0.5' : '';
    
    $o = <<<HTML
        <ul class="list-none m-0 {$indent}">
            {$ul}
        </ul>
    HTML;
    
    return $o;
}

function ordered_list(array $list) {
    
    $ol = '<ol>';
    $counter = 1;
    foreach($list as  $li) {
        $has_list = is_array($li);
        $space = $has_list ? 'px-4' : '';
        $content = $has_list ? ordered_list($li) : "{$counter}. " . $li;
        $ol .= <<< HTML
            <li class="{$space} text-sm"> {$content} </li>
        HTML;
        
        $counter++;
    }
    $ol .= '</ol>';
    
    return $ol;
    
}