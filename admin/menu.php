<?php
require_once 'before_menu.php';
?>


<!-- sidebar menu -->
<div id="sidebar-menu" class="main_menu_side hidden-print main_menu menu_fixed">
    <div class="menu_section">
        <!--<h3>
        <!--Intentionally left blank - don't delete->
    </h3> -->

        <ul class="nav side-menu">

            <li>
                <a href="index.php"><i class="fa fa-home"></i> Home </a>
            </li>
            <?php
            if ($admin->getPrivilegeId() == 1) {
                echo "<li>
                <a href='admins.php'><i class='fa fa-users'></i> Admins </a>
            </li>";
            }
            ?>

            <li>
                <a href="#"><i class="fa fa-calculator"></i> Accounting <span class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu">
                    <li><a href="setup.php"> Setup </a></li>
                    <li><a href="profit.php"> Profit </a></li>
                    <li><a href="receipt.php"> Receipt </a></li>
                </ul>
            </li>
            <li>
                <a href="#"><i class="fa fa-globe"></i> Marketing <span class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu">
                    <li><a href="discount.php">Discount</a></li>
                    <li><a href="promo.php">Promo Codes</a></li>
                </ul>
            </li>

            <li>

                <a href='#'><i class='fa fa-th'></i> Orders <span class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu">
                    <li><a href="delivered.php"> Delivered </a></li>
                    <li><a href="ndelivered.php"> Not Delivered </a></li>
                    <!--<li><a href="#">Recruitment Management</a></li>-->
                </ul>
            </li>
            <li>
                <a href="#"><i class="fa fa-road"></i> Route <span class="label label-success pull-right">Coming Soon</span></a>
            </li>
            <li>
                <a href="#"><i class="fa fa-map-marker"></i> Customer(s) Map <span class="label label-success pull-right">Coming Soon</span></a>
            </li>
            <li><a href="logout.php"><i class="fa fa-sign-out"></i> Log Out</a></li>
        </ul>
    </div>
</div>
<!-- /sidebar menu -->

<!-- /menu footer buttons -->
<!--<div class="sidebar-footer hidden-small">
    <a data-toggle="tooltip" data-placement="top" title="Settings">
        <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
    </a>
    <a data-toggle="tooltip" data-placement="top" title="FullScreen">
        <span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
    </a>
    <a data-toggle="tooltip" data-placement="top" title="Lock">
        <span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
    </a>
    <a data-toggle="tooltip" data-placement="top" title="Logout">
        <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
    </a>
</div>-->
<!-- /menu footer buttons -->
</div>
</div>

<!-- top navigation -->
<div class="top_nav">
    <div class="nav_menu">
        <nav class="" role="navigation">
            <div class="nav toggle">
                <a id="menu_toggle"><i class="fa fa-bars"></i></a>
            </div>

            <ul class="nav navbar-nav navbar-right">
                <li class="">
                    <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                        <!--<img src="../images/img.jpg" alt="">-->
                        <?php
                        if (isset($admin)) {
                            echo $admin->getSurname() . " " . $admin->getOtherNames();
                        }
                        ?>
                        <span class=" fa fa-angle-down"></span>
                    </a>
                    <ul class="dropdown-menu dropdown-usermenu pull-right">
                        <li><a href="#"> Profile</a></li>
                        <!--                        <li>
                                                    <a href="javascript:;">
                                                        <span class="badge bg-red pull-right">50%</span>
                                                        <span>Settings</span>
                                                    </a>
                                                </li>
                                                <li><a href="#">Help</a></li>-->
                        <li><a href="logout.php"><i class="fa fa-sign-out pull-right"></i> Log Out</a></li>
                    </ul>
                </li>

            </ul>
        </nav>
    </div>
</div>
<!-- /top navigation -->
