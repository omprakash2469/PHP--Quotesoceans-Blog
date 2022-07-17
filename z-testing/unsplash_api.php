<?php
if (isset($_GET['query'])) {
    $query = $_GET['query'];
    $clientId = "pygc93ccvg3iOwjia7GQSElcNQv1GFiO96mzch6Ftqw";
    $url = "https://api.unsplash.com/search/photos/?client_id=$clientId&query=$query";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $result = curl_exec($ch);
    curl_close($ch);
    $result = json_decode($result, true);

    foreach ($result['results'] as $url) {
        $urls[] = array(
            'profile' => $url['user']['links']['html'],
            'username' => $url['user']['username'],
            'url' => $url['urls']['regular'],
            'download' => $url['links']['download_location']."&client_id=pygc93ccvg3iOwjia7GQSElcNQv1GFiO96mzch6Ftqw"
        );
    }
    echo "<pre>";
    print_r($result);
    echo "</pre>";
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Display Images</title>
    <style>
        * {
            margin: 0;
            padding: 0;
        }

        .gallery {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            grid-gap: .5rem;
            grid-auto-rows: 500px;
        }

        img {
            width: 100%;
            height: 90%;
            object-fit: cover;
        }
    </style>
</head>

<body>
    <a href="unsplash_api.php">Home</a>
    <a href="?query=nature" name="action">Display Images</a>
    <div class="gallery">
        <?php
        if (isset($urls) && !empty($urls)) :
            foreach ($urls as $url) : ?>
                <figure>
                    <img src="<?php echo $url['url']; ?>" alt="Here is the image you have to display">
                    <p>Photo by <a href="<?php echo $url['profile']; ?>?utm_source=your_app_name&utm_medium=referral"><?php echo $url['username']; ?></a> on <a href="https://unsplash.com/?utm_source=your_app_name&utm_medium=referral">Unsplash</a></p>
                </figure>
        <?php endforeach;
        endif; ?>
    </div>
</body>

</html>