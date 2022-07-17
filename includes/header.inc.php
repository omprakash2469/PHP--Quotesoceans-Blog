<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php htmlout($title); ?></title>
    <link rel="icon" href="/images/q.png" type="images/x-icon">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Slab&family=Crete+Round&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?php htmlout($stylesheet); ?>">
    <link rel="stylesheet" href="/css/utility.css">
    
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-FK300TTDZ8"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'G-FK300TTDZ8');
    </script>

</head>

<body>
    <header id="header" class="d-flex">
        <div class="top">
            <div class="logo">
                <h1><a class="h-primary d-flex" href="/"><img src="/images/q.png" alt="QuotesOceansLogo">uotes<span class="coral">Oceans</span></a></h1>
            </div>
            <div class="menu d-flex">
                <img onclick="navOpen()" src="/images/menu.png" alt="menu" class="invert">
            </div>
        </div>
        <div class="d-flex" id="search-bar">
            <form action="/quotes/" method="get" class="search-form">
                <input type="search" name="search" id="search" placeholder="Search by author name, quote, keyword..." class="search" autocomplete="off" value="<?php if (isset($search)) {htmlout($search);} ?>">
                <button type="submit" class="search-btn d-flex"><img class="search-img" src="/images/search.png" alt="Search here"></button>
            </form>
        </div>
    </header>

    <!-- Navigation Section -->
    <nav id="navigation">
        <div id="navbar">
            <h2>All Categories <span onclick="navClose()">&times;</span></h2>
            <ul class="menu-bar">
                <?php foreach ($categories as $category) : ?>
                    <li><a class="nav-link" href="/quotes/?category=<?php htmlout($category['category']); ?>"><?php htmlout(ucwords($category['category'])); ?></a></li>
                <?php endforeach; ?>
            </ul>
        </div>
    </nav>

    <!-- Scroll Top button -->
    <div>
        <a href="#header" id="scroll-top"><img src="/images/toparrow.png" alt="Scroll top"></a>
    </div>