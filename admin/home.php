<?php include $_SERVER['DOCUMENT_ROOT'] . '/admin/includes/header.html.php'; ?>


<div id="page-wrapper">
    <div id="page-inner">


        <div class="row">
            <div class="col-md-12">
                <h1 class="page-header">
                    Dashboard <small>Omprakash Prajapati</small>
                </h1>
            </div>
        </div>


        <!-- /. ROW  -->

        <div class="row">
            <div class="col-md-3 col-sm-12 col-xs-12">
                <div class="panel panel-primary text-center no-boder bg-color-green">
                    <div class="panel-left pull-left green">
                        <i class="fa fa-user fa-5x"></i>
                    </div>

                    <div class="panel-right pull-right">
                        <h3><?php htmlout($quoteCount); ?></h3>
                        <strong> Quotes</strong>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-12 col-xs-12">
                <div class="panel panel-primary text-center no-boder bg-color-blue">
                    <div class="panel-left pull-left blue">
                        <i class="fa fa-list-alt fa-5x"></i>
                    </div>

                    <div class="panel-right pull-right">
                        <h3><?php htmlout(count(getCategories())); ?></h3>
                        <strong> Categories</strong>

                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-12 col-xs-12">
                <div class="panel panel-primary text-center no-boder bg-color-red">
                    <div class="panel-left pull-left red">
                        <i class="fa fa fa-comments fa-5x"></i>

                    </div>
                    <div class="panel-right pull-right">
                        <h3><?php htmlout($authorCount); ?></h3>
                        <strong> Authors </strong>

                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-12 col-xs-12">
                <div class="panel panel-primary text-center no-boder bg-color-brown">
                    <div class="panel-left pull-left brown">
                        <i class="fa fa-users fa-5x"></i>

                    </div>
                    <div class="panel-right pull-right">
                        <h3><?php htmlout($contactCount); ?></h3>
                        <strong>Contacts</strong>

                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4 col-sm-12 col-xs-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Top Categories
                    </div>
                    <div class="panel-body">
                        <div class="list-group">
                            <?php foreach ($topCat as $key => $value) : ?>
                                <a class="d-flex list-group-item justify-content-between">
                                    <span><?php htmlout(ucwords($key)); ?></span>
                                    <span class="text-dark"><?php htmlout($value); ?></span>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>

            </div>
            <div class="col-md-8 col-sm-12 col-xs-12">

                <div class="panel panel-default">
                    <div class="panel-heading">
                        Top Authors
                    </div>
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>S No.</th>
                                        <th>Author</th>
                                        <th>Profession</th>
                                        <th>No. of Quotes</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($authors as $author) : ?>
                                        <tr>
                                            <td><?php htmlout($author['id']); ?></td>
                                            <td><?php htmlout(ucwords($author['name'])); ?></td>
                                            <td><?php htmlout(ucwords($author['profession'])); ?></td>
                                            <td>Quotes</td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <!-- /. ROW  -->
        <footer>
            <p><a href="https://www.quotesoceans.com/">QuotesOceans.com</a> || All right reserved.</p>
        </footer>
    </div>
    <!-- /. PAGE INNER  -->
</div>
<!-- /. PAGE WRAPPER  -->

<!-- Footer Section -->
<?php include $_SERVER['DOCUMENT_ROOT'] . '/admin/includes/footer.html.php'; ?>