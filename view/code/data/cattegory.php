<?php
    $file_path = __DIR__ . DIRECTORY_SEPARATOR . '../../../core/data/Cattegory.php';
    $file_name = 'Core\Data\Cattegory';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <title><?php echo $file_name; ?> - Code Preview</title>
</head>
<body class="p-12 bg-gray-100">
    
    <header class="mb-8 container mx-auto">
        <div class="text-center mb-6">
            <h1 class="text-3xl font-bold text-gray-800"><?php echo $file_name; ?></h1>
            <p class="text-gray-600 mt-2">Code Preview</p>
        </div>
        
        <!-- Navigation Tree -->
        <div class="bg-white p-4 rounded-lg shadow-md mb-6">
            <h2 class="text-lg font-semibold text-gray-700 mb-3">Navigation</h2>
            <nav class="border border-gray-300 rounded p-4 bg-gray-50">
                <ul class="space-y-2">
                    <li class="font-semibold text-gray-700">Models</li>
                    <li class="ml-4">
                        <a href="../models/pets.php" class="text-blue-600 hover:text-blue-800">Pets</a>
                    </li>
                    <li class="font-semibold text-gray-700 mt-3">Entities</li>
                    <li class="ml-4">
                        <a href="../entities/pet.php" class="text-blue-600 hover:text-blue-800">Pet</a>
                    </li>
                    <li class="font-semibold text-gray-700 mt-3">Lib</li>
                    <ul class="ml-4 space-y-1">
                        <li><a href="../lib/arr.php" class="text-blue-600 hover:text-blue-800">Arr</a></li>
                        <li><a href="../lib/json.php" class="text-blue-600 hover:text-blue-800">Json</a></li>
                        <li><a href="../lib/mat.php" class="text-blue-600 hover:text-blue-800">Mat</a></li>
                        <li><a href="../lib/str.php" class="text-blue-600 hover:text-blue-800">Str</a></li>
                    </ul>
                    <li class="font-semibold text-gray-700 mt-3">Data</li>
                    <li class="ml-4">
                        <a href="cattegory.php" class="text-blue-600 hover:text-blue-800 font-medium">Cattegory</a>
                    </li>
                </ul>
            </nav>
            <div class="mt-4 text-center">
                <a href="../index.php" class="text-gray-600 hover:text-gray-800 text-sm">← Back to Index</a>
            </div>
        </div>
    </header>
    
    <div class="container mx-auto px-4 py-8">
        <div class="bg-white p-6 rounded-lg shadow-md">
            <?php 
                if (file_exists($file_path)) {
                    echo highlight_file($file_path, true);
                } else {
                    echo '<p class="text-red-600">File not found: ' . htmlspecialchars($file_path) . '</p>';
                }
            ?>
        </div>
    </div>
    
</body>
</html>

