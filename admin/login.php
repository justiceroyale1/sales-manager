<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <!-- Meta, title, CSS, favicons, etc. -->
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- Favicon --> 
        <link rel="shortcut icon" href="">
        <link rel="apple-touch-icon" href="">

        <title>Creative Bakers</title>

        <!-- Bootstrap -->
        <link href="../external/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
        <!-- Font Awesome -->
        <link href="../external/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
        <!-- Animate.css -->
        <link href="../external/vendors/animate.css/animate.min.css" rel="stylesheet">

        <!-- Custom Theme Style -->
        <link href="../css/custom.css" rel="stylesheet">
    </head>
    <body class="login">
        <div class="page-header">
            <div class="page-title">
                <!--                <div class="">
                                    <h1>
                <?php
//                        if (isset($school)) {
//                            echo "$school, $town, $state";
//                        } else {
//                            echo "Federal University, Lafia";
//                        }
//                        
                ?>
                                    </h1>
                                </div>-->
                <!--                <div class="title_left">
                                    <h1>
                                        <i class="fa fa-pencil"></i>
                                        Assessment Portal
                                    </h1>
                                </div>-->
            </div>
        </div>
        <div>
            <a class="hiddenanchor" id="signup"></a>
            <a class="hiddenanchor" id="signin"></a>

            <div class="login_wrapper">
                <div class="animate form login_form">
                    <section class="login_content">
                        <?php
                        if (isset($_SESSION['error']) && !empty($_SESSION['error'])) {
                            $error = $_SESSION['error']; // save error session to error variable
                            $_SESSION['error'] = ''; // set error session to empty string (security purpose)

                            echo "
            <div class='animated flipInX col-lg-12 col-md-12 col-sm-12 col-xs-12'>
                <div class='tile-stats alert-error'>
                    <div class='icon'>
                        <i class='fa fa-warning'></i>
                    </div>
                    <div class='count'>Error...</div>
                    <p>$error</p>
                </div>
            </div>
            ";
                        }
                        ?>
                        <form action="loginAdmin.php" method="post">
                            <h1>Admin Login</h1>
                            <div>
                                <input type="text" name="username" maxlength="20" class="form-control" placeholder="*Username" required="required" />
                            </div>
                            <div>
                                <input type="password" name="password" class="form-control" placeholder="*Password" required="required" />
                            </div>
                            <div>
                                <input class="btn btn-round btn-dark" type="reset" value="Cancel">
                                <input class="btn btn-round btn-primary" type="submit" value="Login">
                                <p class="change_link">
                                    <a class="reset_pass" href="#"> Reset Password </a>
                                </p>
                            </div>

                            <div class="clearfix"></div>

                            <div class="separator">
                                <p class="change_link">
                                    <!--<a href="#signup" class="to_register"> Activate Account </a>-->
                                </p>

                                <div class="clearfix"></div>
                                <br />

                                <div>
                                    <h1></h1>
                                    <p>
                                        <small> &copy; 2016 All rights reserved. Powered by Creative Bakers </small>
                                    </p>
                                </div>
                            </div>
                        </form>
                    </section>
                </div>

                <div id="register" class="animate form registration_form">
                    <section class="login_content">
                        <form>
                            <h1>Activate Account</h1>
                            <div>
                                <input type="text" class="form-control" placeholder="Matriculation No." required="required" />
                            </div>
                            <div>
                                <input type="text" class="form-control" placeholder="Pin" required="required" />
                            </div>
                            <div>
                                <input type="text" class="form-control" placeholder="Serial" required="required" />
                            </div>
                            <div>
                                <input class="btn btn-round btn-default" type="reset" value="Cancel">
                                <input class="btn btn-round btn-default" type="submit" value="Activate">
                            </div>

                            <div class="clearfix"></div>

                            <div class="separator">
                                <p class="change_link">
                                    <!--<a href="#signin" class="to_register"> Log in </a>-->
                                </p>

                                <div class="clearfix"></div>
                                <br />

                                <div>
                                    <h1></h1>
                                    <p>
                                        ©2016 All Rights Reserved.
                                        Cynetz Integrated Services Limited.
                                    </p>
                                </div>
                            </div>
                        </form>
                    </section>
                </div>
            </div>
        </div>
    </body>
</html>
