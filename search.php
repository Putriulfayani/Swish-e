<?php
//memeriksa apakah permintaan  yang diterima adalah metode GET dan apakah parameter 'q', 'model', dan 'topk' 
//ada dalam URL, kemudian menyimpan nilainya untuk digunakan lebih lanjut.
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['q']) && isset($_GET['model']) && isset($_GET['topk'])) {
    $searchQuery = $_GET['q'];
    $searchModel = $_GET['model'];
    $topk = $_GET['topk'];

    if ($searchModel == 1) {
        
        $command = "./querydb $searchQuery";
        $result = shell_exec($command);

        
        $searchResults = explode("\n", trim($result));

        
        header("Location: hasil_c.php?q=$searchQuery&results=" . urlencode(implode("\n", $searchResults)) . "&topk=$topk");
        exit();
    } elseif ($searchModel == 2) {
        
        $startTime = microtime(true);

        
        $command = "swish-e -w $searchQuery -f result.index -m $topk";
        $result = shell_exec($command);

        
        $endTime = microtime(true);

        $searchResults = explode("\n", trim($result));

        
        $searchTime = $endTime - $startTime;

        
        header("Location: hasil_swish_e.php?q=$searchQuery&results=" . urlencode(implode("\n", $searchResults)) . "&search_time=$searchTime&topk=$topk");
        exit();
    } else {
        
        header("Location: index.php");
        exit();
    }
} else {
    
    header("Location: index.php");
    exit();
}
?>