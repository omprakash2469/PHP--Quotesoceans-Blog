<?php
$countImg = 30;
$query = "life";
$clientId = "pygc93ccvg3iOwjia7GQSElcNQv1GFiO96mzch6Ftqw";
$url = "https://api.unsplash.com/search/photos/?client_id=$clientId&query=$query";
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$result = curl_exec($ch);
curl_close($ch);
$pretty_print = json_decode($result, JSON_PRETTY_PRINT);


echo "<pre>";
print_r($pretty_print);
echo "</pre>";