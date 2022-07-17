<?php
 include_once $_SERVER['DOCUMENT_ROOT'] . '/shared_includes/functions.php'; 
 include '../includes/header.html.php';
?>

<!-- Header Section -->
<header id="header">
    <h1 class="p-heading"><?php htmlout($pagetitle); ?></h1>
</header>

<section class="container">
    <div class="content">
        <form action="?<?php htmlout($action);?>" method="POST" enctype="multipart/form-data">
            <div>
                <input type="text" name="name" id="name" class="form-control" value='<?php htmlout($name); ?>' placeholder="Category Name">
            </div>
            <div>
                <input type="file" name="upload" id="upload" class="form-control">
            </div>
            <div class="home">
                <input type="hidden" name="id" value=<?php htmlout($id); ?>>
                <a href="../categories" class="btn">Back</a>
                <input type="submit" class="btn" value='<?php htmlout($button); ?>'>
            </div>
        </form>
    </div>
</section>

<!-- Footer Section -->
<?php include '../includes/footer.html.php'; ?>