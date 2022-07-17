<?php
// Replace all special characters with HTML entities
function html($text)
{
    $string = trim($text);
    $string = htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
    return $string;
}
function htmlout($text)
{
    echo html($text);
}

// Formatting Strings
function markdown2html($text)
{
    $text = html($text);

    // Strong Emphasis
    $text = preg_replace('/\*\*(.+?)\*\*/s', '<h4>$1</h4>', $text);
    $text = preg_replace('/\*([^\*]+)\*/', '<h2>$1</h2>', $text);

    // Emphasis and Strong Emphasis
    $text = preg_replace('/_([^_]+)_/', '<em>$1</em>', $text);
    $text = preg_replace('/__(.+?)__/s', '<strong>$1</strong>', $text);

    // Paragraphs
    $text = str_replace('\n\n', "</p><p>", $text);

    // Line Breaks
    $text = str_replace('\n', "<br>", $text);

    // HyperLinks [linked text](link URL)
    $text = preg_replace('/\[([^\]]+)]\(([-a-z0-9._~:\/?#!@$&\'()*+,;=%]+)\)/i', '<a class="blue" href="$2">$1</a>', $text);
    return $text;
}

function markdownout($text)
{
    echo markdown2html($text);
}

// Function to display images
// Hit the endpoint of the download_location and use that url in the $urls to download images
function displayImages($query, $num)
{
    $clientId = "pygc93ccvg3iOwjia7GQSElcNQv1GFiO96mzch6Ftqw";
    $url = "https://api.unsplash.com/search/photos/?client_id=$clientId&query=$query&per_page=$num";
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
            'url' => $url['urls']['regular']
        );
    }
    return $urls;
}

// Build list of categories
function getCategories()
{
    include '_dbconnect.php';
    try {
        $result = $pdo->query("SELECT `id`, `name`, `catImage` FROM `category`");
    } catch (PDOException $e) {
        $error = "Error fetching categories " . $e->getMessage();
        include 'error.html.php';
        exit();
    }
    foreach ($result as $row) {
        $categories[] = array(
            'id' => $row['id'],
            'category' => $row['name'],
            'image' => $row['catImage']
        );
    }
    $pdo = NULL; // close db connection
    $result = NULL; // close db connection
    return $categories;
}

// Build list of authors
function getAuthors()
{
    include '_dbconnect.php';
    try {
        $result = $pdo->query("SELECT `author`.`id`, `name`, `profession` FROM `author_profession` INNER JOIN `author` ON `authorid` = `author`.`id` INNER JOIN `profession` ON `professionid` = `profession`.`id`");
    } catch (PDOException $e) {
        $error = "Error fetching Authors ";
        include 'error.html.php';
        exit();
    }
    foreach ($result as $row) {
        $authors[] = array(
            'id' => $row['id'],
            'name' => $row['name'],
            'profession' => $row['profession']
        );
    }
    $pdo = NULL; // close db connection
    $result = NULL; // close db connection
    return $authors;
}

// Build list of author professions
function getProfessions()
{
    include '_dbconnect.php';
    try {
        $result = $pdo->query("SELECT `id`, `profession` FROM `profession`");
    } catch (PDOException $e) {
        $error = "Error fetching Profession ";
        include 'error.html.php';
        exit();
    }
    foreach ($result as $row) {
        $professions[] = array(
            'id' => $row['id'],
            'profession' => $row['profession']
        );
    }
    $pdo = NULL; // close db connection
    $result = NULL; // close db connection
    return $professions;
}

// Secure user input
function secure($text)
{
    $text = stripslashes($text);
    $text = trim($text);
    return $text;
}

// Get unique records from the array
function unique_multidim_array($array, $key)
{
    $temp_array = array();
    $i = 0;
    $key_array = array();

    foreach ($array as $val) {
        if (!in_array($val[$key], $key_array)) {
            $key_array[$i] = $val[$key];
            $temp_array[$i] = $val;
        }
        $i++;
    }
    return $temp_array;
}

// Get unique name
function getUnique($num){
    $string = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890" . time();
    $text = str_shuffle($string);
    $text = substr($text, 0, $num);
    return $text;
}

// Get category name from id
function cfromId($cid){
    include '_dbconnect.php';
    try {
        $sql = "SELECT `name` FROM `category` WHERE `id` = :id";
        $result = $pdo->prepare($sql);
        $result->bindValue(':id', $cid);
        $result->execute();
    } catch (PDOException $e) {
        $error = "Error fetching categories " . $e->getMessage();
        include 'error.html.php';
        exit();
    }
    $row = $result->fetch();
    $category = strtolower($row['name']);
    $pdo = NULL; // close db connection
    $result = NULL; // close db connection
    return $category;
}

// Get quote image name from quoteid and categorid
function getQuoteImage($category, $qid){
    include '_dbconnect.php';
    try {
        $sql = "SELECT `quoteImg` FROM `$category` WHERE `quoteid` = :qid";
        $result = $pdo->prepare($sql);
        $result->bindValue(':qid', $qid);
        $result->execute();
    } catch (PDOException $e) {
        $error = "Error fetching categories " . $e->getMessage();
        include 'error.html.php';
        exit();
    }
    $row = $result->fetch();
    $imageName = $row['quoteImg'];
    $pdo = NULL; // close db connection
    $result = NULL; // close db connection
    return $imageName;
}

// Count Quotes
function countQuotes(){
    // Fetch Categories
    include '_dbconnect.php';
    try {
        $result = $pdo->query("SELECT `id`, `name` FROM `category`");
    } catch (PDOException $e) {
        $error = "Error fetching categories " . $e->getMessage();
        include 'error.html.php';
        exit();
    }

    // Count Quotes from each category table
    foreach ($result as $row) {
        $cattable = $row['name'];
        try {
            $qresult = $pdo->query("SELECT * FROM `$cattable`");
        } catch (PDOException $e) {
            $error = "Error counting categories ";
            include 'error.html.php';
            exit();
        }
        $num = $qresult->rowCount();
        $total += $num;
    }
    // Return total number of quotes
    return $total;
}

// Count Authors
function countAuthors(){
    // Fetch Authors
    include '_dbconnect.php';
    try {
        $result = $pdo->query("SELECT * FROM `author`");
    } catch (PDOException $e) {
        $error = "Error fetching authors";
        include 'error.html.php';
        exit();
    }
    $total += $result->rowCount();

    // Return total number of authors
    return $total;
}

// Count Contacts
function countContact(){
    // Fetch Contacts
    include '_dbconnect.php';
    try {
        $result = $pdo->query("SELECT * FROM `contact`");
    } catch (PDOException $e) {
        $error = "Error fetching contact";
        include 'error.html.php';
        exit();
    }
    $total += $result->rowCount();

    // Return total number of contacts
    return $total;
}