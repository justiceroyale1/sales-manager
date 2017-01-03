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
                        <h1> Admins </h1>
                        <a href="#admins_dialog" class="btn btn-primary"><i class="fa fa-plus"></i> Add Admin</a>
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
                        <table id="admintable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>
                                        ID
                                    </th>
                                    <th>
                                        Full name
                                    </th>
                                    <th>
                                        Username
                                    </th>
                                    <th>
                                        Access Level
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
                                Add Admin
                            </h1>

                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            <div id='admins_dialog' class='' role='dialog' aria-labelledby='myModalLabel' >
                                <div class='modal-dialog'>
                                    <div class='modal-content'>
                                        <div class='modal-header'>
                                            <!--<button class='close' type='button' data-dismiss='modal' aria-hidden=''>×</button>-->
                                            <h4 id='myModalLabel' class=' modal-title'>
                                                Add Admin
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

                                                <form action='registerAdmin.php'  method='post' id='adminsForm' class='form-horizontal' role='form'>
                                                    <div class='form-group'>
                                                        <!--<label class='col-sm-12 label label-default'>Add vacancies available in your company</label>-->
                                                        <div class='col-sm-12 col-md-12 col-xs-12'>
                                                            <input name='surname' class='form-control' placeholder="*Surname" type='text' required>
                                                        </div>

                                                    </div>
                                                    <div class='form-group'>
                                                        <!--<label class='col-sm-12 label label-default'>Add vacancies available in your company</label>-->
                                                        <div class='col-sm-12 col-md-12 col-xs-12'>
                                                            <input name='other_names' class='form-control' placeholder="*Other names" type='text' required>
                                                        </div>
                                                    </div>
                                                    <div id="username-available" class="col-md-8 col-md-offset-2 col-sm-8 col-sm-offset-4 col-xs-12 alert alert-success">
                                                        <i class="fa fa-check-circle"></i> This username is available.
                                                    </div>
                                                    <div id="username-unavailable" class="col-md-8 col-md-offset-2 col-sm-8 col-sm-offset-4 col-xs-12 alert alert-warning">
                                                        <i class="fa fa-warning"></i> This username is unavailable. Try another one.
                                                    </div>
                                                    <div class='form-group'>
                                                        <!--<label class='col-sm-12 label label-default'>Add vacancies available in your company</label>-->
                                                        <div class='col-sm-12 col-md-12 col-xs-12'>
                                                            <input id='username' name='username' class='form-control' maxlength="20" placeholder="*Create username" type='text' required>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class='col-sm-12 col-md-12 col-xs-12'>
                                                            <input id='' name='password' maxlength="6" class='form-control' placeholder="*Create password" type='password' required>
                                                        </div>
                                                    </div>
                                                    <div class='form-group'>
                                                        <!--<label class='col-sm-12 label label-default'>Add vacancies available in your company</label>-->
                                                        <div class='col-sm-12 col-md-12 col-xs-12'>
                                                            <input id='' name='phone' class='form-control' placeholder="*Enter phone number" type='tel' required>
                                                        </div>

                                                    </div>
                                                    <div class='form-group'>
                                                        <!--<label class='col-sm-12 label label-default'>Add vacancies available in your company</label>-->
                                                        <div class='col-sm-12 col-md-12 col-xs-12'>
                                                            <input id='' name='email' class='form-control' placeholder="Enter email" type='email' >
                                                        </div>

                                                    </div>
                                                    <div class="form-group">
                                                        <div class='col-sm-12 col-md-12 col-xs-12'>
                                                            <input name='address' class='form-control' placeholder="*Address" type='text' required>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label col-md-3 col-sm-3 col-xs-12">
                                                            *Department
                                                        </label>
                                                        <div class="col-md-9 col-sm-9 col-xs-12">
                                                            <select name="priv" class="form-control">
                                                                <?php
                                                                Admin::setConnection(HOST, USER, PASS, DB);
                                                                Admin::showPrivileges();
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <div class="col-md-6 col-sm-6 col-xs-6">
                                                            <input type="reset" class="btn btn-default" value="Cancel">

                                                        </div>
                                                        <div class="col-md-6 col-sm-6 col-xs-6">
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
