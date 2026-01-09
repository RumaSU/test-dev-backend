<?php

require_once(__DIR__ . DIRECTORY_SEPARATOR . '../core/lib/Str.php');
require_once(__DIR__ . DIRECTORY_SEPARATOR . 'list.php');
require_once(__DIR__ . DIRECTORY_SEPARATOR . 'table.php');

use Core\Lib\Str;

function view_result(
    string $section = 'Section', 
    string $quest, 
    string|array $answer, 
    ?string $type = null, 
    string|null $code = null,
    array|string|null $note = null
) {
    $tw = ['table', 'list'];
    $type = strtolower($type);
    if (!in_array($type, $tw)) $type = is_array($type) ? 'list' : null; 
    
    $out_answer = $answer;
    if ($type == $tw[0]) {
        $head = is_array($answer)
            ? array_keys($answer[0])
            : $answer;
                
        $out_answer = view_table($answer, $head);
    }
    if ($type == $tw[1]) $out_answer = view_list($answer);
    
    $code = highlight_string($code, true);
    
    $note_html = '';
    if ($note) {
        $note = Str::htmlspecialchars($note);
        $note_escaped = is_array($note) ? view_list($note) : $note;
        $note_html = <<<HTML
            <!-- Additional note -->
            <div class="mb-4">
                <label class="block text-gray-700 font-medium mb-2">Catatan:</label>
                <div class="w-full p-3 border border-gray-300 rounded bg-yellow-50">
                    <p class="text-gray-700">{$note_escaped}</p>
                </div>
            </div>
        HTML;
    }
    $code_html = '';
    if ($code) {
        $code_html = <<<HTML
            <div class="my-2">
                <details open>
                    <summary class="block text-gray-700 font-medium mb-2 cursor-pointer py-2 px-4 bg-blue-100 rounded-sm">Code</summary>
                    <div class="w-full p-3 border border-gray-300 rounded">
                        {$code}
                    </div>
                </details>
            </div>
        HTML;
    }
    
    $output = <<<HTML
        <section class="mb-10 bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">{$section}</h2>
            
            <!-- Question -->
            <div class="mb-4">
                <label class="block text-gray-700 font-medium mb-2">Pertanyaan:</label>
                <p class="bg-gray-50 p-3 rounded border">{$quest}</p>
            </div>

            <!-- Result -->
            <div class="mb-4">
                <details open>
                    <summary class="block text-green-700 font-medium mb-2 cursor-pointer py-2 px-4 bg-green-100 rounded-sm">Hasil Test:</summary>
                    <div class="w-full p-3 border border-gray-300 rounded">
                        {$out_answer}
                    </div>
                </details>
            </div>
            
            {$code_html}
            
            {$note_html}
        </section>
    HTML;
    
    
    return $output;
}


