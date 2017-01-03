<?php

/**
 * Represents a product object
 * 
 * @author Abutu Justice Royale
 */
require_once '../config.php';
require_once 'Class.Validate.php';

class Product {

    private $__id;
    private $__prdName;
    private $__prdPrice;
    private $__prdCOP;
    private $__prdProfit;
    private $__ts;
    private $__prdImage;
    private $__description;
    private $__prdConfigId;
    static private $connection;

    public function __construct($name) {
        if (Validate::name($name) && (!empty($name))) {
            $this->__prdName = $name;
        } else {
            throw new Exception("Sorry, product name is not valid");
        }
    }

    public function setPrdId($_i) {
        if (Validate::number($_i)) {
            $this->__id = $_i;
        } else {
            throw new Exception("Sorry, product id is invalid");
        }
    }

    public function setPrdName($name) {
        if (Validate::name($name) && (!empty($name))) {
            $this->__prdName = $name;
        } else {
            throw new Exception("Sorry, product name is not valid");
        }
    }

    public function setPrdImage($path) {
        if (Validate::image($path)) {
            $this->__prdImage = $path;
        } else {
            throw new Exception("Sorry, image path is not valid");
        }
    }

    public function setPrdPrice($price) {
        if (Validate::decimal($price)) {
            $this->__prdPrice = $price;
        } else {
            throw new Exception("Sorry, product price is not valid");
        }
    }

    public function setPrdCOP($cop) {
        if (Validate::decimal($cop)) {
            $this->__prdCOP = $cop;
        } else {
            throw new Exception("Sorry, product price is not valid");
        }
    }

    public function setPrdProfit() {
        if (isset($this->__prdPrice) && isset($this->__prdCOP)) {
            $this->__prdProfit = $this->__prdPrice - $this->__prdCOP;
        } else {
            throw new Exception("Price and cost of production must be set");
        }
    }

    public function setTimestamp($ts) {
        if (Validate::timestamp($ts)) {
            $this->__ts = $ts;
        } else {
            throw new Exception("Sorry, the date is not valid");
        }
    }

    static public function isUsed($name) {
        $count = 0;
        if (isset(Product::$connection)) {
            $result = mysqli_query(Product::$connection, "select * from product where product_name='$name'");
            $count = mysqli_num_rows($result);
        } else {
            throw new Exception("Connection has not been established");
        }

        return $count;
    }

    public function setDescription($desc) {
        if (Validate::string($desc)) {
            $this->__description = $desc;
        } else {
            throw new Exception("Sorry, image path is not valid");
        }
    }

    public function getId() {
        return $this->__id;
    }

    public function getPrdName() {
        return $this->__prdName;
    }

    public function getPrdPrice() {
        return $this->__prdPrice;
    }

    public function getPrdCOP() {
        return $this->__prdCOP;
    }

    public function getPrdProfit() {
        return $this->__prdProfit;
    }

    public function getTimestamp() {
        return $this->__ts;
    }

    public function getDescription() {
        return $this->__description;
    }

    public function setProductConfigId($id) {
        if (Validate::number($id)) {
            $this->__prdConfigId = $id;
        } else {
            throw new Exception("Product config id is invalid");
        }
    }

    public function getProductConfigId() {
        return $this->__prdConfigId;
    }

    static public function setConnection($host, $username, $password, $database) {
        Product::$connection = mysqli_connect($host, $username, $password, $database);

        if (mysqli_errno(Product::$connection) != 0) {
            throw new Exception(mysqli_error(Product::$connection));
        }
    }

    static public function getConnection() {
        if (isset(Product::$connection)) {
            return Product::$connection;
        } else {
            throw new Exception("Connection has not been established");
        }
    }

    static public function getJSONData($result) {
        $data = array();
        while ($row = mysqli_fetch_assoc($result)) {
            array_push($data, array("id" => "$row[product_id]", "name" => "$row[product_name]", "price" => number_format($row["price"], '2'), "COP" => number_format($row["cost_of_production"], '2'), "profit" => number_format($row["profit"], '2'), "action" => "<a id='edit' href='#' title='edit' class='pull-left'><i class='fa fa-pencil'></i></a> <a id='delete' href='#' title='delete' class='pull-right'><i class='fa fa-times'></i></a>"));
        }
        return $data;
    }

    static private function getTotalRecords($result) {
        return mysqli_num_rows($result);
    }

    static public function getProducts($dStart, $dLength, $sSortDir, $sEcho) {
        if (isset(Product::$connection)) {
            $result = mysqli_query(Product::$connection, "select * from product, product_config where product.product_config_id = product_config.product_config_id");
            if (mysqli_errno(Product::$connection) == 0) {
                $num = intval($sEcho);
                echo json_encode(array("sEcho" => "$num", "iTotalRecords" => Product::getTotalRecords($result), "iTotalDisplayRecords" => Product::getTotalRecords($result), "aaData" => Product::getJSONData($result)));
            } else {
                throw new Exception(mysqli_error(Admin::$connection));
            }
        }
    }

    private function loadProduct($link, $result) {
        if (mysqli_errno($link) == 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $this->__id = $row['product_id'];
                $this->__prdName = $row['product_name'];
                $this->__prdPrice = $row['price'];
                $this->__prdCOP = $row['cost_of_production'];
                $this->__prdProfit = $row['profit'];
                $this->__ts = $row['date_added'];
                $this->__description = $row['description'];
                $this->__prdConfigId = $row['product_config_id'];
                $this->__prdImage = $row['image'];
            }
        } else {
            throw new Exception(mysqli_error($link));
        }
    }

    public function load() {
        if (isset(Product::$connection)) {

            $query = "select * from product, product_config where product.product_config_id = product_config.product_config_id and product.product_id = '$this->__id'";
            $result = mysqli_query(Product::$connection, $query);

            $this->loadProduct(Product::$connection, $result);
        } else {
            throw new Exception("Connection has not been established");
        }
    }

    static private function loadProductDetails($result, $qty) {
        $prdDetails = array();
        $today = date("Y-m-d h:m:s");
        $query = "select discount from discount where num_of_products <= '$qty' "
                . "and (end_date >= '$today' or end_date = '0000-00-00 00:00:00') "
                . "and discount_type_id = '1' limit 1";
        // get cumulative discount
        $res = mysqli_query(Product::$connection, $query);
        if (mysqli_num_rows($res) == 1) {
            $discount = mysqli_fetch_array($res);
            while ($row = mysqli_fetch_assoc($result)) {
                $total = $row['price'] * $qty;
                $disc = ($discount[0] / 100) * $total;
                // fail safe
                if($total > $disc){
                    $price = $total - $disc;
                }else{
                    $price = $total;
                }
                array_push($prdDetails, array("id" => "$row[product_id]", "prdName" => "$row[product_name]", "price" => number_format($price), "qty" => "$qty"));
            }
        } else {
            while ($row = mysqli_fetch_assoc($result)) {
                array_push($prdDetails, array("id" => "$row[product_id]", "prdName" => "$row[product_name]", "price" => number_format($row['price'] * $qty), "qty" => "$qty"));
            }
        }
        echo json_encode(array('product' => $prdDetails));
    }

    static public function getProductDetails($prdId, $qty) {
        if (Validate::number($prdId) && Validate::number($qty)) {
            $query = "select * from product, product_config where product.product_config_id = product_config.product_config_id and product_id = '$prdId'";
            $result = mysqli_query(Product::$connection, $query);

            if (mysqli_errno(Product::$connection) == 0) {
                Product::loadProductDetails($result, $qty);
            } else {
                throw new Exception(mysqli_error(Product::$connection));
            }
        } else {
            throw new Exception("product id or quantity is invalid");
        }
    }

    public function save() {
        if (isset(Product::$connection)) {
            $query = "insert into product_config"
                    . " values('NULL','$this->__prdPrice','$this->__prdCOP','$this->__prdProfit','$this->__ts')";
            mysqli_query(Product::$connection, $query);

            if (mysqli_errno(Product::$connection) == 0) {
                $config_id = mysqli_insert_id(Product::$connection);
                $query = "insert into product"
                        . " values('NULL','$this->__prdName','$this->__description', '$this->__prdImage', '$config_id')";
                mysqli_query(Product::$connection, $query);

                if (mysqli_errno(Product::$connection) != 0) {
                    throw new Exception(mysqli_error(Product::$connection));
                }
            } else {
                throw new Exception(mysqli_error(Product::$connection));
            }
        } else {
            throw new Exception("Connection has not been established");
        }
    }

    static private function loadProducts($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<option value='" . $row['product_id'] . "'>" . $row['product_name'] . "</option>";
        }
    }

    static public function showProducts() {
        if (isset(Product::$connection)) {
            $result = mysqli_query(Product::$connection, "select * from product");
            if (mysqli_errno(Product::$connection) == 0) {
                Product::loadProducts($result);
            } else {
                throw new Exception(mysqli_error(Product::$connection));
            }
        }
    }

}
