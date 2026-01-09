<?php
    $core_base = __DIR__ . DIRECTORY_SEPARATOR . '../../core';
    $code_base = __DIR__;
    
    // Structure mapping
    $structure = [
        'models' => [
            'Pets.php' => 'pets.php'
        ],
        'entities' => [
            'Pet.php' => 'pet.php'
        ],
        'lib' => [
            'Arr.php' => 'arr.php',
            'Json.php' => 'json.php',
            'Mat.php' => 'mat.php',
            'Str.php' => 'str.php'
        ],
        'data' => [
            'Cattegory.php' => 'cattegory.php'
        ]
    ];
    
    function buildTree($structure, $code_base) {
        $html = '<ul class="space-y-2">';
        foreach ($structure as $folder => $files) {
            $html .= '<li class="font-semibold text-gray-700 mb-2">' . ucfirst($folder) . '</li>';
            $html .= '<ul class="ml-4 space-y-1">';
            foreach ($files as $original => $view) {
                $path = $code_base . DIRECTORY_SEPARATOR . $folder . DIRECTORY_SEPARATOR . $view;
                $exists = file_exists($path);
                $class = $exists ? 'text-blue-600 hover:text-blue-800 font-medium' : 'text-gray-400 cursor-not-allowed';
                $title = str_replace('.php', '', $original);
                $icon = $exists ? '✓' : '✗';
                $html .= '<li class="flex items-center gap-2">';
                $html .= '<span class="' . ($exists ? 'text-green-600' : 'text-gray-400') . '">' . $icon . '</span>';
                $html .= '<a href="' . ($exists ? htmlspecialchars($folder . '/' . $view) : '#') . '" class="' . $class . '">' . htmlspecialchars($title) . '</a>';
                $html .= '</li>';
            }
            $html .= '</ul>';
        }
        $html .= '</ul>';
        return $html;
    }
    
    $tree = buildTree($structure, $code_base);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <title>Code Preview - Core Directory</title>
</head>
<body class="p-12 bg-gray-100">
    
    <header class="mb-8 text-center">
        <div class="mb-4">
            <a href="../../index.php" class="inline-flex items-center gap-2 px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white font-medium rounded-lg shadow-md transition-colors duration-200">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
                </svg>
                <span>Kembali ke Index Utama</span>
            </a>
        </div>
        <h1 class="text-3xl font-bold text-gray-800">Core Directory - Code Preview</h1>
        <p class="text-gray-600 mt-2">Pilih file untuk melihat preview kode</p>
    </header>
    
    <div class="container mx-auto px-4 py-8 max-w-4xl">
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">File Structure</h2>
            <nav class="border border-gray-300 rounded p-4 bg-gray-50">
                <?php echo $tree; ?>
            </nav>
            <div class="mt-4 space-y-3">
                <div class="p-3 bg-blue-50 rounded border border-blue-200">
                    <p class="text-sm text-gray-700">
                        <strong>Note:</strong> Setiap file preview memiliki navigasi tree yang sama untuk memudahkan berpindah antar file.
                    </p>
                </div>
                <div class="p-3 bg-yellow-50 rounded border border-yellow-200">
                    <p class="text-sm text-gray-700 mb-2">
                        <strong>⚠️ Catatan Penting:</strong>
                    </p>
                    <ul class="text-sm text-gray-700 space-y-1 list-disc list-inside mb-3">
                        <li>Tool preview code ini dibuat oleh <strong>AI Assistance (Cursor Agent AI)</strong> untuk mempercepat proses preview code saja, bukan bagian dari core logic code aplikasi.</li>
                        <li>Ini adalah <strong>test requirement</strong> yang mengizinkan penggunaan AI Assist, namun dengan catatan bahwa penggunaan <strong>AI (Gemini dan Cursor Agent AI) hanya pada saat melakukan testing function atau class tertentu</strong> saja untuk memastikan apakah fungsi-fungsi sudah berjalan dengan benar atau belum, bukan berarti seluruh core logic dibuat oleh AI.</li>
                        <li>Fitur ini membantu developer untuk <strong>quick review</strong> dan validasi kode sebelum melakukan pengujian yang lebih mendalam.</li>
                    </ul>
                    <div class="mt-3 p-3 bg-white rounded border border-yellow-300">
                        <p class="text-xs font-semibold text-gray-700 mb-2">📝 Prompt yang digunakan untuk generate file preview ini:</p>
                        <div class="text-xs text-gray-600 bg-gray-50 p-2 rounded font-mono leading-relaxed">
                            <p class="mb-2"><strong>Prompt utama:</strong></p>
                            <p class="italic">"@view/code/models/pets.php buatkan seluruh code yang ada di core agar bisa di preview lansung seperti ini, buatkan strukturnya juga sama, bagian header atau section lainnya buatkan tree untuk mengunjungi file file lainnya juga"</p>
                        </div>
                    </div>
                    <div class="mt-3 p-3 bg-white rounded border border-blue-300">
                        <p class="text-xs font-semibold text-gray-700 mb-2">🔍 Prompt Testing & Validasi Kode yang Digunakan (AI Assistance):</p>
                        <div class="text-xs text-gray-600 bg-gray-50 p-2 rounded leading-relaxed space-y-1.5">
                            <p>1. Analisa dan validasi implementasi class <code class="text-xs bg-gray-200 px-1 rounded">Pets</code> untuk memastikan seluruh fungsi telah sesuai dengan requirement test yang diberikan.</p>
                            <p>2. Pengujian ulang fungsi-fungsi utama dengan fokus pada identifikasi bug atau edge-case yang berpotensi menimbulkan hasil tidak sesuai.</p>
                            <p>3. Validasi fungsi flatten array recursive pada helper library untuk memastikan perilaku rekursif berjalan dengan benar.</p>
                            <p>4. Validasi keterkaitan antara implementasi method dan hasil akhir yang digunakan pada file entry-point (<code class="text-xs bg-gray-200 px-1 rounded">index.php</code>).</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
</body>
</html>

