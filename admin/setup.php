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
                        <h1> Products </h1>
                        <a href="#prd_dialog" class="btn btn-primary"><i class="fa fa-plus"></i> Add Product </a>
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
                        <table id="prdtable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>
                                        ID
                                    </th>
                                    <th>
                                        Name
                                    </th>
                                    <th>
                                        Price (Naira)
                                    </th>
                                    <th>
                                        Cost of Production (Naira)
                                    </th>
                                    <th>
                                        Profit (Naira)
                                    </th>
                                    <th>
                                        Action
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

            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h1>
                                Add Product
                            </h1>

                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            <div id='prd_dialog' class='' role='dialog' aria-labelledby='myModalLabel' >
                                <div class='modal-dialog'>
                                    <div class='modal-content'>
                                        <div class='modal-header'>
                                            <!--<button class='close' type='button' data-dismiss='modal' aria-hidden=''>×</button>-->
                                            <h4 id='myModalLabel' class=' modal-title'>
                                                Add Product
                                                <small>
                                                    fields with asterisk(*) are required
                                                </small>
                                            </h4>
                                        </div>
                                        <div class='modal-body'>
                                            <div id='testmodal' style='padding: 5px 20px'>
                                                <?php
                                                if (isset($_SESSION['error'])) {
                                                    echo "<label id='msg' class='col-sm-12 col-md-10 label label-danger'>$_SESSION[error]</label>";
                                                    unset($_SESSION['error']);
                                                } elseif (isset($_SESSION['success'])) {
                                                    echo "<label id='msg' class='col-sm-12 col-md-10 label label-success'>$_SESSION[success]</label>";
                                                    unset($_SESSION['success']);
                                                }
                                                //unset($_SESSION['success']);
                                                ?>

                                                <form action='registerProduct.php'  method='post' id='prdForm' enctype="multipart/form-data" class='form-horizontal' role='form'>

                                                    <div id="prdName-available" class="col-md-8 col-md-offset-2 col-sm-8 col-sm-offset-4 col-xs-12 alert alert-success">
                                                        <i class="fa fa-check-circle"></i> This product name is available.
                                                    </div>
                                                    <div id="prdName-unavailable" class="col-md-8 col-md-offset-2 col-sm-8 col-sm-offset-4 col-xs-12 alert alert-warning">
                                                        <i class="fa fa-warning"></i> This product name is unavailable. Try another one.
                                                    </div>
                                                    <div class='form-group'>
                                                        <!--<label class='col-sm-12 label label-default'>Add vacancies available in your company</label>-->
                                                        <div class='col-sm-12 col-md-12 col-xs-12'>
                                                            <input id='prdName' name='prdName' class='form-control' maxlength="20" placeholder="*Enter product name" type='text' required>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class='col-sm-12 col-md-12 col-xs-12'>
                                                            <input name='prdPrice' class='form-control' min="1" placeholder="*Enter product price" type='number' required>
                                                        </div>
                                                    </div>
                                                    <div class='form-group'>
                                                        <!--<label class='col-sm-12 label label-default'>Add vacancies available in your company</label>-->
                                                        <div class='col-sm-12 col-md-12 col-xs-12'>
                                                            <input id='' name='prdCOP' class='form-control' min="1" placeholder="*Enter cost of production" type='number' required>
                                                        </div>

                                                    </div>
                                                    <div class='form-group'>
                                                        <!--<label class='col-sm-12 label label-default'>Add vacancies available in your company</label>-->
                                                        <div class='col-sm-12 col-md-12 col-xs-12'>
                                                            <input name='prdImage' class='form-control' placeholder="Enter product image (1MB Max.)" type='file' >
                                                        </div>

                                                    </div>

                                                    <div class='form-group'>
                                                        <div class='col-sm-12 col-md-12 col-xs-12'>
                                                            <textarea name='prdDescription' class="resizable_textarea form-control" maxlength="400" style="overflow: hidden; word-wrap: break-word; resize: vertical; height: 94px;" placeholder="Enter product description"></textarea>
                                                        </div>

                                                    </div>

                                                    <div class="form-group">
                                                        <div class="col-md-3 col-sm-3 col-xs-12">
                                                            <input type="reset" class="btn btn-default" value="Cancel">

                                                        </div>
                                                        <div class="col-md-9 col-sm-9 col-xs-12">
                                                            <input type="submit" class="btn btn-primary" value="Add">

                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                        <div class='modal-footer'>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <!-- /page content -->

    <?php
    require_once 'footer.php';
    ?>
