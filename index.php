<?php
    $dir = __DIR__ . DIRECTORY_SEPARATOR;
    require_once($dir . 'core/models/Pets.php');
    require_once($dir . 'core/entities/Pet.php');
    require_once($dir . 'core/lib/Json.php');
    require_once($dir . 'core/lib/Arr.php');
    require_once($dir . 'core/lib/Str.php');
    require_once($dir . 'core/data/Cattegory.php');

    require_once($dir . 'view/table.php');
    require_once($dir . 'view/list.php');
    require_once($dir . 'view/result.php');
    include_once($dir . 'code_preview.php');
    
    use Core\Models\Pets;
    use Core\Entities\Pet;
    use Core\Lib\Json;
    use Core\Lib\Arr;
    use Core\Lib\Str;
    use Core\Data\Cattegory;
    
    /**
     * Esa adalah seorang pecinta hewan yang sangat menyayangi peliharaannya. 
     * Di rumahnya, ia memelihara beberapa anjing dengan ras dan nama yang berbeda-beda. 
     * Otto, seekor Golden Retriever yang energik dan senang bermain bola. 
     * Max, seekor Siberian Husky yang terkenal dengan bulunya yang lebat dan matanya yang biru. 
     * Bob, seekor Beagle yang selalu ceria dan aktif mengajak Esa bermain di taman. 
     * 
     * Esa juga memiliki beberapa kucing peliharaan, 
     * Luna, seekor kucing Persia yang anggun dan manja, 
     * Milo, seekor British Short Hair yang cerdas dan aktif.
     * 
     * Esa juga memelihara beberapa ikan hias, 
     * 
     * Nana, ikan Koi yang indah, 
     * Goldie, ikan mas yang berwarna cerah. 
     * 
     * Otto, Luna, Milo, Max merupakan kesayangan esa.
     */

    /** Test Requirement
     *- 1. Buat data array dengan merepresentasikan jenis, ras, nama dan Karakteristik
     *- 2. Buat fungsi untuk menambah hewan peliharaan baru Esa, yaitu seekor badak Jawa dengan nama Rino yang pekerja keras. yang juga menjadi kesayangan esa
     *- 3. Buat fungsi untuk mengambil hewan kesayangan Esa secara descending dan ascending
     *- 4. Buat fungsi untuk mengganti kucing Persia menjadi kucing Maine Coon
     *- 5. Buat fungsi untuk menghitung jumlah hewan peliharan esa sesuai dengan jenisnya
     *- 6. Buat fungsi untuk mengecek hewan peliharaan esa yang mengandung kata palindrome beserta panjang string dari namanya
     *- 7. Buat fungsi untuk menjumlah bilangan genap dari array berikut [15,18,3,9,6,2,12,14] dan munculkan bilangan genap nya 
     *- 8. Buat fungsi dengan paramater yang di inisiasi sendiri untuk menentukan apakah dua string adalah anagram (memiliki huruf yang sama dengan jumlah yang sama, tetapi urutan berbeda).
     *- 9. Buatkan fungsi yang memformat json (assets/json/case.json) menjadi seperti (assets/json/expectation.json)
     */
    
    //1
    $esa = new Pets(
        new Pet('Otto', 'Anjing', 'Golden Retriever', ['Energik', 'Senang bermain bola'], true), 
        new Pet('Max', 'Anjing', 'Siberian Husky', ['Bulu lebat', 'Mata biru'], true),
        new Pet('Bob', 'Anjing', 'Beagle', ['Ceria', 'Aktif mengajak bermain di taman']),
        new Pet('Luna', 'Kucing', 'Persia', ['Anggun', 'Manja'], true),
        new Pet('Milo', 'Kucing', 'British Short', ['Cerdas', 'Aktif'], true),
        new Pet('Nana', 'Ikan', 'Koi', ['Indah']),
        new Pet('Goldie', 'Ikan', 'Mas', ['Warna Cerah']),
    );
    $esa->add(new Pet('Rino', 'Badak', 'Badak Jawa', 'Pekerja Keras', true));
    $q1 = $esa->get()->all(true);
    
    //2
    $q2 = $esa->get()->all(true);
    
    //3
    $q3_1 = $esa->get()->favorites(true, true);
    $q3_2 = $esa->get()->favorites(false, true);
    
    //4
    $esa->change()->race('Persia', 'Maine Coon');
    $q4 = $esa->get()->all(true);
    
    //5
    $q5 = $esa->get()->total()->species();
    
    //6
    $q6 = $esa->get()->palindrome()->names();
    
    //7
    $n = [15,18,3,9,6,2,12,14];
    $q7 = Arr::sum_even($n);
    
    //8
    $s = [
        ['education', 'ducatione'],
        ['kasur', 'rusak'],
        ['kasur', 'rusaa'],
        ['lapar', 'rappa'],
        ['makan', 'namak'],
    ];
    foreach($s as &$i) {
        $i[] = Str::isAnagram($i[0], $i[1]); 
    }
    $q8 = $s;

    //9
    $path = __DIR__ . DIRECTORY_SEPARATOR . 'assets/json/case.json';
    $data = Json::file()->extract($path, true);
    $data_agg = Cattegory::aggregator($data['data']);
    $q9 = $data_agg;
    $note9 = [
        'Implementasi menggunakan class terpisah (JsonFile dan Cattegory) dengan validasi MIME type dan file size mungkin terlihat berlebihan untuk simple JSON extraction. Namun, pendekatan ini dipilih setelah mencoba beberapa implementasi untuk memastikan error handling yang baik dan struktur code yang lebih maintainable.',
        'Perbedaan Value Nilai Total Pada Data' => [
            'Pada case.json nilai total Bayam adalah 12, namun pada expectation.json menjadi 25.',
            'Berdasarkan perhitungan total dari case.json keseluruhan yang benar seharusnya adalah 163, bukan 176 seperti yang ada di expectation.json.',
            'Perbedaan ini terjadi karena nilai Bayam yang seharusnya 12 diubah menjadi 25 di expectation.json.'
        ]
    ];
    
    $path_expectation = __DIR__ . DIRECTORY_SEPARATOR . 'assets/json/expectation.json';
    $q9_expectation = Json::file()->extract($path_expectation, true);
    
    
    $result = [
        view_result(
            'Section 1: Membuat Data Array Hewan Peliharaan', 'Buat data array dengan merepresentasikan jenis, ras, nama dan Karakteristik', 
            $q1, 
            'table', 
            $code1,
        ),
        view_result(
            'Section 2: Menambah Hewan Peliharaan Baru', 'Buat fungsi untuk menambah hewan peliharaan baru Esa, yaitu seekor badak Jawa dengan nama Rino yang pekerja keras. yang juga menjadi kesayangan esa', 
            $q2, 
            'table', 
            $code2,
        ),
        view_result(
            'Section 3: Mengambil Hewan Kesayangan (Sorting)', 'Buat fungsi untuk mengambil hewan kesayangan Esa secara descending dan ascending', 
            $q3_1, 
            'table', 
            $code3,
            'Pendekatan ini mungkin terlihat over-engineered untuk satu requirement, namun dipilih setelah mencoba beberapa implementasi.'
        ),
        view_result(
            'Section 4: Mengganti Ras Kucing', 'Buat fungsi untuk mengganti kucing Persia menjadi kucing Maine Coon', 
            $q4, 
            'table', 
            $code4,
            'Implementasi menggunakan anonymous class dengan dynamic method calling (getter/setter) mungkin terasa berlebihan, namun dipilih untuk konsistensi dengan pattern yang sudah digunakan dan memungkinkan fleksibilitas untuk perubahan di masa depan.'
        ),
        view_result(
            'Section 5: Menghitung Jumlah Hewan per Jenis', 'Buat fungsi untuk menghitung jumlah hewan peliharan esa sesuai dengan jenisnya', 
            $q5, 
            'list', 
            $code5,
            'Method chaining dengan multiple level anonymous classes (get()->total()->species()) mungkin terlihat kompleks untuk requirement sederhana ini. Namun, pendekatan ini dipilih setelah mencoba beberapa implementasi untuk memastikan konsistensi API dan reusability code.'
        ),
        view_result(
            'Section 6: Mengecek Palindrome pada Nama Hewan', 'Buat fungsi untuk mengecek hewan peliharaan esa yang mengandung kata palindrome beserta panjang string dari namanya', 
            $q6, 
            'table', 
            $code6,
            'Implementasi menggunakan method chaining dengan anonymous class yang memanggil method di level Pet entity mungkin terlihat over-engineered. Namun, pendekatan ini dipilih setelah mencoba beberapa implementasi untuk menjaga konsistensi dengan pattern yang sudah ada dan memudahkan ekstensi untuk field lainnya.'
        ),
        view_result(
            'Section 7: Menjumlah Bilangan Genap', 'Buat fungsi untuk menjumlah bilangan genap dari array berikut [15,18,3,9,6,2,12,14] dan munculkan bilangan genap nya ', 
            $q7, 
            'list', 
            $code7
        ),
        view_result(
            'Section 8: Menentukan Anagram', 'Buat fungsi dengan paramater yang di inisiasi sendiri untuk menentukan apakah dua string adalah anagram (memiliki huruf yang sama dengan jumlah yang sama, tetapi urutan berbeda).', 
            $q8, 
            'table', 
            $code8
        ),
        view_result(
            'Section 9: Memformat dan Mengagregasi Data JSON', 'Buatkan fungsi yang memformat json (assets/json/case.json) menjadi seperti (assets/json/expectation.json)', 
            $q9, 
            'list', 
            $code9,
            $note9
        ),
        view_result(
            'Section 9 Expectation: Format Agregasi Data Expectation JSON', '', 
            $q9_expectation, 
            'list'
        ),
    ];
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <title>Document</title>
</head>
<body class="p-12 bg-gray-100">
    
    <header class="mb-8 text-center">
        <h1 class="text-3xl font-bold text-gray-800">Test Requirement Report</h1>
        <p class="text-gray-600 mt-2">Berikut adalah hasil dari test requirement yang telah dilakukan.</p>
        <div class="mt-4">
            <a href="view/code/index.php" target="_blank" class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg shadow-md transition-colors duration-200">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17.25 6.75L22.5 12l-5.25 5.25m-10.5 0L1.5 12l5.25-5.25m7.5-3l-4.5 16.5" />
                </svg>
                <span>Lihat Preview Full Code</span>
            </a>
        </div>
    </header>
    
    <div class="container mx-auto px-4 py-8">
        <?php 
            foreach($result as $r) {
                echo $r;
            }
        ?>
    </div>
    


</body>
</html>