<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: url('images/gambar1.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0;
        }

        .card {
            background-color: #DCDCDC; 
            transition: background-color 0.3s ease-in-out; 
        }

        .card:hover {
            transform: scale(1.05);
            transition: transform 0.3s ease-in-out;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            background-color: #e9ecef; 
        }
    </style>
    <title>Hasil Pencarian - Model C</title>
</head>

<body>
    <div class="container">
        <h1 class="text-center">Hasil Pencarian - Model C</h1>

        <?php
        if (isset($_GET['q']) && isset($_GET['results'])) {
            $searchQuery = $_GET['q'];
            $searchResults = urldecode($_GET['results']);
            $searchTime = null;
        ?>

            <div class="row">
                <div class="col"></div>
                <div class="col align-self-center">
                    <?php
                    echo "<p>Query: $searchQuery</p>";

                    
                    $resultLines = explode("\n", trim($searchResults));

                    
                    foreach ($resultLines as $line) {
                        // Proses setiap baris hasil
                        if (preg_match('/^#Time required: (\d+\.\d+) mseconds$/', $line, $matches)) {
                            $searchTime = $matches[1];
                            echo "<p>Waktu Pencarian: $searchTime mseconds</p>";
                            break;
                        }
                    }

                    echo "<p>Hasil Pencarian:</p>";
                    ?>
                </div>
                <div class="col"></div>
            </div>
        <?php

            foreach ($resultLines as $line) {
                // Proses setiap baris hasil
                if (preg_match('/^Document \[(\d+)\s+([^\]]+)\] or docno (\d+) ranked = (\d+\.\d+)$/', $line, $matches)) {
                    $documentNumber = $matches[1];
                    $documentName = $matches[2];
                    $docno = $matches[3];
                    $ranked = $matches[4];

                    // Baca isi file untuk mendapatkan title dan content
                    $filePath = "data/$documentName";
                    $fileContent = file_get_contents($filePath);
                    preg_match('/<title>(.*?)<\/title>/', $fileContent, $titleMatches);
                    preg_match('/<content>(.*?)<\/content>/', $fileContent, $contentMatches);

                    $title = isset($titleMatches[1]) ? htmlspecialchars(trim($titleMatches[1])) : "Title Not Found";
                    $rawContent = isset($contentMatches[1]) ? htmlspecialchars(trim($contentMatches[1])) : "Content Not Found";

                    // Batasi konten menjadi 50 karakter
                    $limitedContent = substr($rawContent, 0, 50);
        ?>
                    <div class="row">
                        <div class="col"></div>
                        <div class="col align-self-center">
                            <div class="card" style="width: 31rem;">
                                <div class="card-body">
                                    <h5 class="card-title">
                                        <?php
                                        echo "Document Number: $docno"
                                        ?>
                                    </h5>
                                    <p class="card-text">
                                        <?php
                                        echo "Title: $title"
                                        ?>
                                    </p>
                                    <p class="card-text">
                                        <?php
                                        echo "Ranked: $ranked"
                                        ?>
                                    </p>
                                    <p class="card-text">
                                        <?php
                                        echo "Content: $limitedContent..."
                                        ?>
                                    </p>
                                    <a href="content.php?file=<?php echo "$filePath" ?>" target="_blank" class="btn btn-primary">Lihat File</a>
                                </div>
                            </div>
                        </div>
                        <div class="col"></div>
                    </div>
        <?php
                    echo "<hr>";
                }
            }
        } else {
            echo "<p>Hasil pencarian tidak valid.</p>";
        }
        ?>

        <p><a href="/Swish-e/">Kembali ke Halaman Utama</a></p>
    </div>
    </body>

</html>
