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
            background-color: #DCDCDC; /* Change this to the desired background color */
            transition: background-color 0.3s ease-in-out; /* Add transition for smooth color change */
        }

        .card:hover {
            transform: scale(1.05);
            transition: transform 0.3s ease-in-out;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            background-color: #e9ecef; /* Change this to the desired background color on hover */
        }
    </style>
    <title>Hasil Pencarian - Swish-e</title>
</head>

<body>
    <div class="container">
        <h1 class="text-center">Hasil Pencarian - Swish-e</h1>

        <?php
        if (isset($_GET['q']) && isset($_GET['results']) && isset($_GET['search_time']) && isset($_GET['topk'])) {
            $searchQuery = $_GET['q'];
            $searchResults = urldecode($_GET['results']);
            $searchTime = $_GET['search_time'];
            $topk = $_GET['topk'];
        ?>
            <div class="row">
                <div class="col"></div>
                <div class="col align-self-center">
                    <?php
                    echo "<p>Query: $searchQuery</p>";
                    echo "<p>Waktu Pencarian: $searchTime detik</p>";
                    echo "<p>Hasil Pencarian:</p>";
                    ?>
                </div>
                <div class="col"></div>
            </div>
        <?php
            $resultLines = explode("\n", trim($searchResults));
            $documentCount = 0;

            foreach ($resultLines as $line) {
                if (preg_match('/^(\d+)\s+(.+)\s+"(.+)"\s+(\d+)$/', $line, $matches)) {
                    $documentNumber = $matches[1];
                    $filePath = $matches[2];
                    $title = $matches[3];
                    $score = $matches[4];

                    $fileName = basename($filePath);

                    $fileContent = file_get_contents("data/$fileName");
                    preg_match('/<content>(.*?)<\/content>/', $fileContent, $contentMatches);
                    $content = isset($contentMatches[1]) ? htmlspecialchars(trim($contentMatches[1])) : "Content Not Found";

                    $limitedContent = substr($content, 0, 50);
        ?>
                    <div class="row">
                        <div class="col"></div>
                        <div class="col align-self-center">
                            <div class="card" style="width: 31rem;">
                                <div class="card-body">
                                    <h5 class="card-title">
                                        <?php echo "Document Number: $documentNumber" ?>
                                    </h5>
                                    <p class="card-text">
                                        <?php echo "Title: $title" ?>
                                    </p>
                                    <p class="card-text">
                                        <?php echo "Score: $score" ?>
                                    </p>
                                    <p class="card-text">
                                        <?php echo "Content: $limitedContent..." ?>
                                    </p>
                                    <a href="content.php?file=<?php echo "$filePath" ?>" target="_blank" class="btn btn-primary">Lihat File</a>
                                </div>
                            </div>
                        </div>
                        <div class="col"></div>
                    </div>
        <?php
                    echo "<hr>";
                    $documentCount++;
                }
            }

            echo "<h4>Jumlah Dokumen: $documentCount</h4>";
        } else {
            echo "<p>Hasil pencarian tidak valid.</p>";
        }
        ?>

        <p><a href="/Swish-e/">Kembali ke Halaman Utama</a></p>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

</html>
