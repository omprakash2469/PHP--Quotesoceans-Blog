<?php include $_SERVER['DOCUMENT_ROOT'] . '/admin/includes/header.html.php'; ?>

<!-- Categories Section -->
<div id="page-wrapper">
    <div id="page-inner">

        <!-- /. ROW  -->
        <div class="row">
            <div class="col-md-12">
                <h1 class="page-header">
                    Manage Categories <button type="button" onclick="modalOpen()" class="btn btn-primary">Add Category</button>
                </h1>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="modal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addCategoryLabel">Add New Category</h5>
                        <button onclick="closeModal()" type="button" class="close">
                            <span>&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <form id="addform" action="?addform" method="POST" enctype="multipart/form-data">
                                    <div class="form-group">
                                        <input class="form-control" type="text" name="name" id="name" placeholder="Enter Category Name" value=''>
                                    </div>
                                    <div class="form-group">
                                        <a href="" target="_blank" id="imgupload">Upload Image Here</a>
                                    </div>
                                    <div class="form-group">
                                        <input class="form-control" type="file" name="upload" id="upload">
                                    </div>
                                    <input type="hidden" name="id" value='' id="hiddenid">
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" onclick="closeModal()">Close</button>
                        <button id="addbtn" type="submit" class="btn btn-primary" form="addform" name="action" value="delete">Add Category</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- /. ROW  -->
        <div class="row">
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover" id="category-table">
                        <thead>
                            <tr>
                                <th scope="col">Id</th>
                                <th scope="col">Categories</th>
                                <th scope="col">Image</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($categories as $category) : ?>
                                <tr>
                                    <td><?php htmlout($category['id']); ?></td>
                                    <td><?php htmlout(ucwords($category['category'])); ?></td>
                                    <td><a href="/images/categories/<?php htmlout($category['image']); ?>" target="_blank"><?php htmlout($category['image']); ?></a></td>
                                    <td id="actions">
                                        <button class="btn btn-default btn-circle" id="edit"><i class="fa fa-pencil d-flex justify-content-center"></i></button>
                                        <button class="btn btn-default btn-circle" id="delete"><i class="fa fa-trash-o d-flex justify-content-center"></i></button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
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