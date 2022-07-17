<?php include $_SERVER['DOCUMENT_ROOT'] . '/admin/includes/header.html.php'; ?>

<!-- Authors Section -->
<div id="page-wrapper">
    <div id="page-inner">

        <!-- /. ROW  -->
        <div class="row">
            <div class="col-md-12">
                <h1 class="page-header">
                    <?php htmlout(ucwords($category)); ?> Quotes <button type="button" onclick="modalOpen()" class="btn btn-primary">Add Quote</button>
                </h1>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="modal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addAuthorLabel"><?php htmlout($pagetitle); ?></h5>
                        <button onclick="closeModal()" type="button" class="close">
                            <span>&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <form id="addform" action="?<?php htmlout($action); ?>" method="POST">
                                    <div class="form-group">
                                        <input class="form-control" type="text" name="name" id="name" placeholder="Enter Name" value='<?php htmlout($name); ?>'>
                                    </div>
                                    <input type="hidden" name="id" value='<?php htmlout($id); ?>' id="hiddenid">
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" onclick="closeModal()">Close</button>
                        <button id="addbtn" type="submit" class="btn btn-primary" form="addform" name="action" value="delete"><?php htmlout($button); ?></button>
                    </div>
                </div>
            </div>
        </div>

        <!-- /. ROW  -->
        <div class="row">
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover" id="authors-table">
                        <thead>
                            <tr>
                                <th scope="col">Id</th>
                                <th scope="col">Authors</th>
                                <th scope="col">Quotes</th>
                                <th scope="col">Image</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($quotes as $quote) : ?>
                                <tr>
                                    <td><?php htmlout($quote['id']); ?></td>
                                    <td><?php htmlout($quote['author']); ?></td>
                                    <td><?php markdownout($quote['text']); ?></td>
                                    <td><a href="/images/<?php htmlout($category . "/" . $quote['image']); ?>"><?php //htmlout($quote['image']); ?>Happy Hours</a></td>
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