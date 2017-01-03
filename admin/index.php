<?php
require_once 'header.php';
require_once 'menu.php';

?>


<!-- page content -->
<div class="right_col" role="main">
    <div class="">
        <div class="row top_tiles">
            <div class="animated flipInY col-lg-4 col-md-4 col-sm-4 col-xs-12">
                <div class="tile-stats">
                    <div class="icon"><i class="fa fa-cart-plus"></i></div>
                    <div class="count"><?php echo 10; ?></div>
                    <h3>New Orders</h3>
                    <p></p>
                </div>
            </div>
            <div class="animated flipInY col-lg-4 col-md-4 col-sm-4 col-xs-12">
                <div class="tile-stats">
                    <div class="icon"><i class="fa fa-check"></i></div>
                    <div class="count"><?php echo 5; ?></div>
                    <h3>Delivered</h3>
                    <p></p>
                </div>
            </div>
            <div class="animated flipInY col-lg-4 col-md-4 col-sm-4 col-xs-12">
                <div class="tile-stats">
                    <div class="icon"><i class="fa fa-th"></i></div>
                    <div class="count">
                        <?php
                        echo 5;
                        ?>
                    </div>
                    <h3>Not delivered</h3>
                    <p></p>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                </div>
            </div>
        </div>

    </div>
</div>
<!-- /page content -->

<?php
require_once 'footer.php';
?>
