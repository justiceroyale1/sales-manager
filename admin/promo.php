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
                        <h1> Promo Codes </h1>
                        <a href="#promo_dialog" class="btn btn-primary"><i class="fa fa-plus"></i> Add Promo Code </a>
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
                        <table id="promotable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>
                                        ID
                                    </th>
                                    <th>
                                        Promo Code
                                    </th>
                                    <th>
                                        Discount Type
                                    </th>
                                    <th>
                                        Discount (%)
                                    </th>
                                    <th>
                                        Status
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
                                Add Promo Code

                            </h1>

                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            <div id='promo_dialog' class='' role='dialog' aria-labelledby='myModalLabel' >
                                <div class='modal-dialog'>
                                    <div class='modal-content'>
                                        <div class='modal-header'>
                                            <!--<button class='close' type='button' data-dismiss='modal' aria-hidden=''>×</button>-->
                                            <h4 id='myModalLabel' class=' modal-title'>
                                                Generate Promo Code
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

                                                <form action='registerPromoCode.php'  method='post' id='add_admins_form' class='form-horizontal' role='form'>

                                                    <div class="form-group">
                                                        <div class='col-sm-12 col-md-12 col-xs-12'>
                                                            <input name='promoAmount' class='form-control' min="1" placeholder="*Number to generate" type='number' required>
                                                        </div>
                                                    </div>
                                                    <div class='form-group'>
                                                        <!--<label class='col-sm-12 label label-default'>Add vacancies available in your company</label>-->
                                                        <div class='col-sm-12 col-md-12 col-xs-12'>
                                                            <input id='' name='promoMin' class='form-control' min="0" step="0.1" placeholder="*Minimum discount in percentage" type='number' required>
                                                        </div>
                                                    </div>
                                                    <div class='form-group'>
                                                        <!--<label class='col-sm-12 label label-default'>Add vacancies available in your company</label>-->
                                                        <div class='col-sm-12 col-md-12 col-xs-12'>
                                                            <input id='' name='promoMax' class='form-control' min="0" step="0.1" placeholder="*Maximum discount in percentage" type='number' required>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <div class="col-md-3 col-sm-3 col-xs-12">
                                                            <input type="reset" class="btn btn-default" value="Cancel">

                                                        </div>
                                                        <div class="col-md-9 col-sm-9 col-xs-12">
                                                            <input type="submit" class="btn btn-primary" value="Generate">

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
