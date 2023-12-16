<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Konten File</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<style>
    body {
        font-family: 'Poppins', sans-serif;
        color: #2D3748;
        background: url('images/gambar1.jpg');
        background-size: cover;
        background-position: center;
        min-height: 100vh;
        margin: 0;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .container {
        max-width: 800px;
        padding: 2rem;
        background-color: rgba(255, 255, 255, 0.9);
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        border-radius: 8px;
        transition: transform 0.3s ease-in-out;
    }

    .container:hover {
        transform: scale(1.05);
    }

    h1 {
        font-size: 2.5rem;
        color: #4A5568;
        text-align: center;
        margin-bottom: 1.5rem;
    }

    p {
        margin-bottom: 1.25rem;
        line-height: 1.6;
    }
</style>

<body class="bg-gray-100 font-sans">

    <div class="container mx-auto p-8">
        <?php
        if (isset($_GET['file'])) {
            $fileName = htmlspecialchars($_GET['file']);

            // Dapatkan path yang terstandarisasi
            $realPath = realpath($fileName);

            // Pastikan file ada dan dalam direktori yang diizinkan
            if ($realPath !== false && strpos($realPath, realpath("swish-e/data")) === 0) {
                // Extract title and content from the file
                $fileContent = file_get_contents($realPath);
                $lines = explode("\n", $fileContent);

                // Display the title
                if (preg_match('/<title>(.*?)<\/title>/', $lines[0], $matches)) {
                    $title = htmlspecialchars(trim($matches[1]));
                    echo "<h1 class='text-4xl font-extrabold mb-6 text-center text-indigo-600'>$title</h1>";
                }

                // Display the content
                if (preg_match('/<content>(.*?)<\/content>/', $fileContent, $matches)) {
                    $content = htmlspecialchars(trim($matches[1]));
                    echo "<p class='mb-4 text-gray-800 leading-7 font-serif'>$content</p>";
                }
            } else {
                echo "<p class='text-gray-700 mt-4'>File tidak ditemukan. Path yang diuji: " . realpath($fileName) . "</p>";
            }
        } else {
            echo "<p class='text-gray-700 mt-4'>Parameter file tidak valid.</p>";
        }
        ?>
    </div>

</body>

</html>
