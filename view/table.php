<?php

// require_once();

include_once(__DIR__ . DIRECTORY_SEPARATOR . 'list.php');

function view_table(array $data, array|null $head = null) {
    
    $render_head = function($items) {
        $th = '';
        foreach($items as $i) {
            $i = ucfirst($i);
            $th .= <<<HTML
                <th class="px-4 py-2 border-b text-left">{$i}</th>
            HTML;
        }
        
        return $th;
    };
    
    $render_body = function ($items) {
        $items = is_array($items[0]) ? $items : [$items];
        
        $tr = '';
        foreach($items as $row) {
            $td = '';
            foreach ($row as $col) {
                if (is_array($col)) $c = view_list($col);
                else {
                    $c = is_bool($col)
                        ? ($col ? '✔' : '❌') 
                        : $col;
                }
                
                $s = is_bool($col)
                    ? ($col ? 'font=semibold text-green-600' : 'font=semibold text-red-600')
                    : '';
                
                $td .= "<td class=\"px-4 py-2 border-b border-black {$s}\">{$c}</td>";
            }
            
            $tr .= "<tr>{$td}</tr>";
        }
        
        return $tr;
    };
    
    return <<<HTML
        
        <table class="min-w-full bg-white border border-gray-200">
            <thead>
                <!-- <tr class="bg-gray-100">
                    <th colspan="9999" class="border border-black">AAAA</th>
                </tr> -->
                <tr class="bg-gray-100">
                    {$render_head($head)}
                </tr>
            </thead>
            <tbody>
                {$render_body($data)}
            </tbody>
        </table>
    HTML;
    
}

?>
