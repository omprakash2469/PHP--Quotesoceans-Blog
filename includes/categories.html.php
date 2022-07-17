<!-- Header Section -->
<?php include 'includes/header.inc.php'; ?>

<!-- Categories Section -->
<section class="container">
    <div class="c-header">
        <h3>Trending Categories >></h3>
    </div>
    <div class="categories">
        <div class="gallery">
            <?php foreach ($categories as $category) : ?>
                <figure class="gallery__item gallery__item--<?php htmlout($category['id']); ?>">
                    <img src="/images/categories/<?php htmlout($category['image']); ?>" alt="Quotes on <?php htmlout($category['category']); ?>" class="gallery__img">
                    <figcaption class="box-desc">
                        <a href="quotes/?category=<?php htmlout($category['category']); ?>" class="d-flex"><?php htmlout(ucwords($category['category'])); ?></a>
                    </figcaption>
                </figure>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Authors Section -->
<section class="container_2">
    <div class="c_2-heading">
        <h2>Search By Authors</h2>
    </div>
    <div class="author_grid">
        <?php foreach ($authors as $author) : ?>
            <div>
                - <a href="?id=<?php htmlout($author['id']); ?>" class="a-link"><?php htmlout(ucwords($author['name'])); ?></a>
            </div>
        <?php endforeach; ?>
    </div>
</section>

<!-- Footer Section  -->
<?php include 'includes/footer.inc.php'; ?>