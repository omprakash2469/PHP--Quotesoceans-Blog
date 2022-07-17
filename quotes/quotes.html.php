<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/header.inc.php'; ?>

<!-- Quotes Section -->
<section class="container">
    <div class="c-header">
        <h3><?php htmlout($heading); ?></h3>
    </div>
    <div class="categories">
        <!-- Display All Quotes with Images -->
        <div class="gallery_2">
            <?php foreach ($quotes as $key => $value) : ?>
                <figure class="gallery_2_item">
                    <img class="gallery_2_img" src="<?php htmlout($urls[$key]['url']); ?>" title="<?php htmlout($value['author']); ?>" alt="<?php markdownout($value['quote']); ?>">
                    <figcaption class="gallery_2_info">
                        <blockquote class="gallery_2_quote"><?php markdownout($value['quote']); ?></blockquote>
                        <q class="gallery_2_author"><?php markdownout(strtoupper($value['author'])); ?></q>
                    </figcaption>
                    <div class="none">
                        <p><?php htmlout($urls[$key]['profile']); ?></p>
                        <p><?php htmlout($urls[$key]['username']); ?></p>
                    </div>
                </figure>
            <?php endforeach; ?>
        </div>

        <!-- Image Display Modal -->
        <div id="myModal" class="modal">
            <div class="d-flex popAni">
                <figure class="modal-content">
                    <img class="modal-img" id="modal_img" src="">
                    <figcaption class="modal_2_info">
                        <blockquote class="modal_2_quote" id="caption"></blockquote>
                        <q class="modal_2_author" id="captionAuthor"></q>
                    </figcaption>
                </figure>
                <div class="modal_icon">
                    <span class="para">
                        Photo by <a id="link_name" class="coral" target="_blank" href=""></a> on <a class="coral" target="_blank" href="https://unsplash.com/?utm_source=quotesOceans&utm_medium=referral">Unsplash</a>
                    </span>
                </div>
            </div>
            <span class="close" onclick="modalClose()">&times;</span>
        </div>
    </div>
</section>

<!-- Footer Section -->
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/footer.inc.php'; ?>