<?php include '../includes/header.html.php'; ?>
<header id="header">
    <h1 class="p-heading"><?php htmlout($pagetitle); ?></h1>
</header>
<section class="container">
    <div class="content">
        <form action="?" method="POST" enctype="multipart/form-data">
            <div>
                <select name="author" id="author" class="form-control">
                    <option value="">-- Select Author --</option>
                    <?php foreach ($authors as $author) : ?>
                        <option value="<?php htmlout($author['id']); ?>" <?php if ($author['id'] == $authorid) { echo ' selected'; } ?>>
                            <?php htmlout($author['name']);?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div>
                <input type="file" name="upload" id="upload" class="form-control">
            </div>
            <fieldset class="form-control">
                <legend>Categories :</legend>
                <div class="ul-grid">
                        <?php foreach ($categories as $category) : ?>
                            <div class="left">
                                <input type="checkbox" name="categories[]" id="category<?php htmlout($category['id']); ?>" value="<?php htmlout($category['category']) ?>" <?php if ($category['id']==$cid) { echo ' checked'; } ?>>
                                <label for="category<?php htmlout($category['id']); ?>"><?php htmlout($category['category']); ?></label>
                            </div>
                        <?php endforeach; ?>
                    </div>
            </fieldset>
            <div>
                <textarea name="text" id="text" cols="40" rows="10" class="form-control"><?php htmlout($text); ?></textarea>
            </div>
            <div class="home">
                <input type="hidden" name="cid" value="<?php htmlout($cid); ?>">
                <input type="hidden" name="qid" value="<?php htmlout($qid); ?>">
                <input type="hidden" name="action" value="<?php htmlout($action); ?>">
                <a class="btn" href="../quotes">Back</a>
                <input type="submit" name="submit" value="<?php htmlout($button); ?>" class="btn">
            </div>
        </form>
    </div>
</section>

<!-- Footer Section -->
<?php include '../includes/footer.html.php'; ?>