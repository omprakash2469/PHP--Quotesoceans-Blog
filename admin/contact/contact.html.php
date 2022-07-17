<?php include $_SERVER['DOCUMENT_ROOT'] . '/admin/includes/header.html.php'; ?>

<!-- Authors Section -->
<div id="page-wrapper">
    <div id="page-inner">

        <!-- /. ROW  -->
        <div class="row">
            <div class="col-md-12">
                <h1 class="page-header">
                    <!-- Manage Authors <small><a href="?add" class="h4 text-primary">Add Author</a></small> -->
                    Manage Contacts
                </h1>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="addAuthor">
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
                    <table class="table table-striped table-bordered table-hover" id="table">
                        <thead>
                            <tr>
                                <th scope="col">Id</th>
                                <th scope="col">firstName</th>
                                <th scope="col">lastName</th>
                                <th scope="col">locate</th>
                                <th scope="col">email</th>
                                <th scope="col">sub</th>
                                <th scope="col">msg</th>
                                <th scope="col">dt</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($contacts as $contact) : ?>
                                <tr>
                                    <td><?php htmlout($contact['id']); ?></td>
                                    <td><?php htmlout($contact['firstName']); ?></td>
                                    <td><?php htmlout($contact['lastName']); ?></td>
                                    <td><?php htmlout($contact['locate']); ?></td>
                                    <td><?php htmlout($contact['email']); ?></td>
                                    <td><?php htmlout($contact['sub']); ?></td>
                                    <td><?php htmlout($contact['msg']); ?></td>
                                    <td><?php htmlout($contact['dt']); ?></td>
                                    <td id="actions">
                                        <button class="btn btn-default btn-circle" id="edit"><i class="fa fa-trash-o d-flex justify-content-center"></i></button>
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