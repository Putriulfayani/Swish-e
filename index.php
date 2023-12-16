<?php
// Periksa apakah form pencarian telah dikirimkan
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['q'])) {
    // Tangkap kata kunci pencarian dari URL
    $searchQuery = $_GET['q'];

    // Lakukan sesuatu dengan kata kunci pencarian, contoh: tampilkan pesan
    $searchMessage = "Anda mencari: " . htmlspecialchars($searchQuery);
} else {
    // Jika tidak ada kata kunci pencarian, set pesan pencarian kosong
    $searchMessage = "Silakan masukkan kata kunci di formulir di atas.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil Pencarian</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">

    <div class="container mx-auto p-8">
        <h1 class="text-3xl font-bold text-center mb-8">Hasil Pencarian</h1>

        <div class="w-full max-w-md mx-auto">
            <p class="text-center text-gray-700"><?= $searchMessage ?></p>
        </div>
    </div>

</body>
</html>
