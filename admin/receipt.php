<?php
require_once 'header.php';
require_once 'menu.php';
?>


<!-- page content -->
<div class="right_col" role="main">
    <div class="">

        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="title">
                        <h1> Receipts </h1>
                        
                        <ul class="nav navbar-right panel_toolbox">
                            <li>
                                <a class="collapse-link">
                                    <i class="fa fa-chevron-down"></i>
                                </a>
                            </li>
                        </ul>

                        <div class="clearfix"></div>
                    </div>

                    <div class="x_content">
                        <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>
                                        ID
                                    </th>
                                    <th>
                                        Product
                                    </th>
                                    <th>
                                        Quantity
                                    </th>
                                    <th>
                                        Customer
                                    </th>
                                    <th>
                                        Date Ordered
                                    </th>
                                    <th>
                                        Discount (%)
                                    </th>
                                    <th>
                                        Paid
                                    </th>
                                    <th>
                                        Date Paid
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <!-- /page content -->

    <?php
    require_once 'footer.php';
    ?>
