<?php include $_SERVER['DOCUMENT_ROOT'] . '/admin/includes/header.html.php'; ?>

<!-- Categories Section -->
<div id="page-wrapper">
    <div id="page-inner">

        <!-- /. ROW  -->
        <div class="row">
            <div class="col-md-12">
                <h1 class="page-header">
                    Manage Quotes
                </h1>
            </div>
        </div>

        <!-- /. ROW  -->
        <div class="row">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Select Category to view quotes
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover" id="authors-table">
                            <thead>
                                <tr>
                                    <th scope="col">Id</th>
                                    <th scope="col">Categories</th>
                                    <th scope="col">Image</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($categories as $category) : ?>
                                    <tr>
                                        <td><?php htmlout($category['id']); ?></td>
                                        <td><a href="?cid=<?php htmlout($category['id']); ?>"><?php htmlout(ucwords($category['category'])); ?></a></td>
                                        <td><a href="/images/categories/<?php htmlout($category['image']); ?>" target="_blank"><?php htmlout($category['image']); ?></a></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>

        <!-- /. ROW  -->
        <footer>
            <p><a href="https://www.quotesoceans.com/">QuotesOceans.com</a> || All right reserved.</p>
        </footer>
    </div>
</div>

<!-- Footer Section -->
<?php include $_SERVER['DOCUMENT_ROOT'] . '/admin/includes/footer.html.php'; ?>