<?php 
    header('Content-type: application/xml');

    include $_SERVER['DOCUMENT_ROOT']. '/shared_includes/_dbconnect.php';

    try {
        $result = $pdo->query("SELECT * FROM `post`");
    } catch (PDOException $e) {
        echo "Failed to fetch links ";
        exit();
    }

    include 'sitemap-xml.xml';
    foreach ($result as $row) {
        echo '<url>';
            echo '<loc>'.$row['link'] . '</loc>';
            echo '<lastmod>'. $row['date']. '</lastmod>';
            echo '<changefreq>daily</changefreq>';
        echo '</url>';
    }
    
    echo '</urlset>';
?>