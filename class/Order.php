<?php

/**
 * Description of Order
 *
 * @author Abutu Justice Royale
 */
require_once 'Class.Validate.php';

class Order {

    private $__orderId;
    private $__quantity;
    private $__status;
    private $__prdId;
    private $__prdConfigId;
    private $__custId;
    private $__custTypeId;
    private $__receiptId;
    static private $connection;

    public function __construct() {
        $this->__date = date("Y-m-d h:m:s");
        $this->__status = 0;
    }

    public function setOrderId($id) {
        if (Validate::number($id)) {
            $this->__orderId = $id;
        } else {
            throw new Exception("order id is invalid");
        }
    }

    public function getOrderId() {
        return $this->__orderId;
    }

    public function setQuantity($qty) {
        if (Validate::number($qty)) {
            $this->__quantity = $qty;
        } else {
            throw new Exception("quantity is invalid");
        }
    }

    public function getQuantity() {
        return $this->__quantity;
    }

    public function setStatus($stat) {
        if (Validate::number($stat)) {
            $this->__status = $stat;
        } else {
            throw new Exception("status is invalid");
        }
    }

    public function getStatus() {
        return $this->__status;
    }

    public function setDate($d) {
        if (Validate::timestamp($d)) {
            $this->__date = $d;
        } else {
            throw new Exception("date is invalid");
        }
    }

    public function getDate() {
        return $this->__date;
    }

    public function setCustomerId($id) {
        if (Validate::number($id)) {
            $this->__custId = $id;
        } else {
            throw new Exception("customer id is invalid");
        }
    }

    public function getCustomerId() {
        return $this->__custId;
    }

    public function setReceiptId($id) {
        if (Validate::number($id)) {
            $this->__receiptId = $id;
        } else {
            throw new Exception("receipt id is invalid");
        }
    }

    public function getReceiptId() {
        return $this->__receiptId;
    }

    public function setProductId($id) {
        if (Validate::number($id)) {
            $this->__prdId = $id;
        } else {
            throw new Exception("Product id is invalid");
        }
    }

    public function getProductId() {
        return $this->__prdId;
    }

    public function setProductConfigId($id) {
        if (Validate::number($id)) {
            $this->__prdConfigId = $id;
        } else {
            throw new Exception("Order config id is invalid");
        }
    }

    public function getProductConfigId() {
        return $this->__prdConfigId;
    }

    public function setCustomerTypeId($id) {
        if (Validate::number($id)) {
            $this->__custTypeId = $id;
        } else {
            throw new Exception("Customer type id is invalid");
        }
    }

    public function getCustomerTypeId() {
        return $this->__custTypeId;
    }

    static public function setConnection($host, $username, $password, $database) {
        Order::$connection = mysqli_connect($host, $username, $password, $database);

        if (mysqli_errno(Order::$connection) != 0) {
            throw new Exception(mysqli_error(Order::$connection));
        }
    }

    static public function getConnection() {
        if (isset(Order::$connection)) {
            return Order::$connection;
        } else {
            throw new Exception("Connection has not been established");
        }
    }

    static private function loadOrderDetails($result, $qty) {
        $prdDetails = array();
        $today = date("Y-m-d h:m:s");
        $query = "select discount from discount where num_of_products <= '$qty' "
                . "and (end_date >= '$today' or end_date = '0000-00-00 00:00:00') "
                . "and discount_type_id = '1' limit 1";
        // get cumulative discount
        $res = mysqli_query(Order::$connection, $query);
        if (mysqli_num_rows($res) == 1) {
            $discount = mysqli_fetch_array($res);
            while ($row = mysqli_fetch_assoc($result)) {
                $price = ($discount / 100) * ($row['price'] * $qty);
                array_push($prdDetails, array("id" => "$row[product_id]", "prdName" => "$row[product_name]", "price" => number_format($price), "qty" => "$qty"));
            }
        } else {
            while ($row = mysqli_fetch_assoc($result)) {
                array_push($prdDetails, array("id" => "$row[product_id]", "prdName" => "$row[product_name]", "price" => number_format($row['price'] * $qty), "qty" => "$qty"));
            }
        }

        echo json_encode(array('product' => $prdDetails));
    }

    static private function failSafe($price, $discount) {
        $dis = ($discount / 100) * $price;
        if ($price > $dis) {
            $pay = $price - $dis;
        } else {
            $pay = $price;
        }
        return $pay;
    }

    static private function showOrderDetails($result, $receiptId) {
        $details = "";
        while ($row = mysqli_fetch_assoc($result)) {
            if ($row['discount'] > 0) {
                $price = $row['price'] * $row['quantity'];
                // fail safe
                $pay = Order::failSafe($price, $row['discount']);
            }else{
                $pay = $row['price'] * $row['quantity'];
            }
            $details = "<div class='row'><div class='col-md-1 col-sm-1 col-xs-1 id'> $row[product_id] </div>"
                    . "<div class='col-md-3 col-sm-3 col-xs-3'> $row[product_name] </div>"
                    . "<div class='col-md-3 col-sm-3 col-xs-3'> ". number_format($pay) ." </div>"
                    . "<div class='col-md-3 col-sm-3 col-xs-3'><input type='number' min='1' class='form-control qty' value='$row[quantity]'></div>"
                    . "<div class='col-md-2 col-sm-2 col-xs-2'>"
                    . "<a id='edelete' href='#' title='delete' class=''><i class='fa fa-times'></i></a>"
                    . "</div></div>";
            echo $details;
        }
        echo "<input id='receiptId' type='hidden' value='$receiptId'>";
    }

    static public function getOrderRecords($receiptId) {
        if (Validate::number($receiptId)) {
            $query = "select * from product, product_order, product_config, receipt, discount "
                    . "where product_order.product_id = product.product_id "
                    . "and product_order.product_config_id = product_config.product_config_id "
                    . "and product_order.receipt_id = receipt.receipt_id "
                    . "and discount.num_of_products <= product_order.quantity "
                    . "and product_order.receipt_id = '$receiptId'";
            $result = mysqli_query(Order::$connection, $query);

            if (mysqli_errno(Order::$connection) == 0) {
                Order::showOrderDetails($result, $receiptId);
            } else {
                throw new Exception(mysqli_error(Order::$connection));
            }
        } else {
            throw new Exception("order id is invalid");
        }
    }

    static public function getOrderDetails($prdId, $qty) {
        if (Validate::number($prdId) && Validate::number($qty)) {
            $query = "select * from product, product_config where product.product_config_id = product_config.product_config_id and product_id = '$prdId'";
            $result = mysqli_query(Order::$connection, $query);

            if (mysqli_errno(Order::$connection) == 0) {
                Order::loadOrderDetails($result, $qty);
            } else {
                throw new Exception(mysqli_error(Order::$connection));
            }
        } else {
            throw new Exception("product id or quantity is invalid");
        }
    }

    static private function getTotalRecords($result) {
        return mysqli_num_rows($result);
    }

    static public function getJSONCOData($result) {
        $data = array();
        while ($row = mysqli_fetch_assoc($result)) {
            switch ($row['delivery_status']) {
                case 0:
                    $status = "<label class='label label-info'>Processing</label>";
                    $action = "<a id='' href='edit.php?id=$row[receipt_id]' title='edit' class='edit'><i class='fa fa-pencil'></i></a> <a id='$row[product_order_id]' href='#' title='delete' class='pull-right delete'><i class='fa fa-times'></i></a>";
                    break;
                case 1:
                    $status = "<label class='label label-info'>Shipping</label>";
                    $action = "<a id='' href='edit.php?id=$row[receipt_id]' title='delete' class='delete'><i class='fa fa-times'></i></a>";
                    break;
                case 2:
                    $status = "<label class='label label-success'>Delivered</label>";
                    $action = "<label class='label label-warning'>No Action</label>";
                    break;

                default:
                    $status = "<label class='label label-info'>Processing</label>";
                    $action = "<a id='' href='edit.php?id=$row[receipt_id]' title='edit' class='edit'><i class='fa fa-pencil'></i></a> <a id='$row[product_order_id]' href='#' title='delete' class='pull-right delete'><i class='fa fa-times'></i></a>";
                    break;
            }
            if ($row["date_paid"] == "0000-00-00 00:00:00") {
                $pdate = "<label class='label label-danger'>Not paid</label>";
            } else {
                $pdate = $row["date_paid"];
            }
            array_push($data, array("product_order_id" => "$row[product_order_id]", "product_name" => "$row[product_name]", "quantity" => number_format($row["quantity"]), "delivery_status" => "$status", "date" => "$row[date]", "tamt" => number_format($row["total_amount"]), "date_paid" => "$pdate", "action" => "$action"));
        }
        return $data;
    }

    static public function getJSONData($result) {
        $data = array();
        while ($row = mysqli_fetch_assoc($result)) {
            switch ($row['delivery_status']) {
                case 0:
                    $status = "<label class='label label-danger'>Unconfirmed</label>";
                    break;
                case 1:
                    $status = "<label class='label label-info'>Confirmed</label>";
                    break;
                case 2:
                    $status = "<label class='label label-success'>Delivered</label>";
                    break;

                default:
                    $status = "<label class='label label-info'>Processing</label>";
                    break;
            }
            if ($row["date_paid"] == "0000-00-00 00:00:00") {
                $pdate = "<label class='label label-danger'>Not paid</label>";
            } else {
                $pdate = $row["date_paid"];
            }
            array_push($data, array("product_order_id" => "$row[product_order_id]", "product_name" => "$row[product_name]", "quantity" => number_format($row["quantity"]), "customer" => "$row[surname] $row[other_names]", "odate" => "$row[date]", "pdate" => "$pdate", "stat" => "$status", "action" => "<a id='confirm' href='#' title='confirm' class=''><i class='fa fa-check'></i></a> <a id='delete' href='#' title='delete' class='pull-right'><i class='fa fa-times'></i></a>"));
        }
        return $data;
    }

    static public function getUndeliveredOrders($dStart, $dLength, $sSortDir, $sEcho) {
        if (isset(Order::$connection)) {
            $query = "select * from product_order, product, product_config, customer, receipt "
                    . "where product_order.product_id = product.product_id "
                    . "and product_order.customer_id = customer.customer_id "
                    . "and product_order.receipt_id = receipt.receipt_id "
                    . "and product_order.product_config_id = product_config.product_config_id "
                    . "and product_order.delivery_status < '2'";
            $result = mysqli_query(Order::$connection, $query);
            if (mysqli_errno(Order::$connection) == 0) {
                $num = intval($sEcho);
                echo json_encode(array("sEcho" => "$num", "iTotalRecords" => Order::getTotalRecords($result), "iTotalDisplayRecords" => Order::getTotalRecords($result), "aaData" => Order::getJSONData($result)));
            } else {
                throw new Exception(mysqli_error(Order::$connection));
            }
        }
    }

    static public function getDeliveredOrders($dStart, $dLength, $sSortDir, $sEcho) {
        if (isset(Order::$connection)) {
            $query = "select * from product_order, product, product_config, customer, receipt "
                    . "where product_order.product_id = product.product_id "
                    . "and product_order.customer_id = customer.customer_id "
                    . "and product_order.receipt_id = receipt.receipt_id "
                    . "and product_order.product_config_id = product_config.product_config_id "
                    . "and product_order.delivery_status = '2'";
            $result = mysqli_query(Order::$connection, $query);
            if (mysqli_errno(Order::$connection) == 0) {
                $num = intval($sEcho);
                echo json_encode(array("sEcho" => "$num", "iTotalRecords" => Order::getTotalRecords($result), "iTotalDisplayRecords" => Order::getTotalRecords($result), "aaData" => Order::getJSONData($result)));
            } else {
                throw new Exception(mysqli_error(Order::$connection));
            }
        }
    }

    static public function searchOrdersForCustomer($dStart, $dLength, $sEcho, $custId, $searchVal) {
        if (isset(Order::$connection)) {
            $query = "select * from product_order, product, product_config, customer, receipt "
                    . "where product_order.product_id = product.product_id "
                    . "and product_order.customer_id = customer.customer_id "
                    . "and product_order.receipt_id = receipt.receipt_id "
                    . "and product_order.product_config_id = product_config.product_config_id "
                    . "and product_order.customer_id = '$custId' "
                    . "and (product.product_name like '%$searchVal%' or "
                    . "receipt.date_paid like '%$searchVal%' or "
                    . "product_order.date like '%$searchVal%')"
                    . "limit $dStart, $dLength";
            $result = mysqli_query(Order::$connection, $query);
            if (mysqli_errno(Order::$connection) == 0) {
                $num = intval($sEcho);
                echo json_encode(array("sEcho" => "$num", "iTotalRecords" => Order::getTotalRecords($result), "iTotalDisplayRecords" => Order::getTotalRecords($result), "aaData" => Order::getJSONCOData($result)));
            } else {
                throw new Exception(mysqli_error(Order::$connection));
            }
        }
    }

    static public function getOrdersForCustomer($dStart, $dLength, $sEcho, $custId, $sSortDir = "asc", $orderCol = "product_order_id") {
        if (isset(Order::$connection)) {
            $query = "select * from product_order, product, product_config, customer, receipt "
                    . "where product_order.product_id = product.product_id "
                    . "and product_order.customer_id = customer.customer_id "
                    . "and product_order.receipt_id = receipt.receipt_id "
                    . "and product_order.product_config_id = product_config.product_config_id "
                    . "and product_order.customer_id = '$custId' "
                    . "order by $orderCol $sSortDir "
                    . "limit $dStart, $dLength";
            $result = mysqli_query(Order::$connection, $query);
            if (mysqli_errno(Order::$connection) == 0) {
                $num = intval($sEcho);
                echo json_encode(array("sEcho" => "$num", "iTotalRecords" => Order::getTotalRecords($result), "iTotalDisplayRecords" => Order::getTotalRecords($result), "aaData" => Order::getJSONCOData($result)));
            } else {
                throw new Exception(mysqli_error(Order::$connection));
            }
        }
    }

    private function loadOrder($link, $result) {
        if (mysqli_errno($link) == 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $this->__orderId = $row['product_order_id'];
                $this->__custTypeId = $row['customer_type_id'];
                $this->__custId = $row['customer_id'];
                $this->__prdConfigId = $row['product_config_id'];
                $this->__prdId = $row['product_id'];
                $this->__quantity = $row['quantity'];
                $this->__receiptId = $row['receipt_id'];
                $this->__status = $row['delivery_status'];
            }
        } else {
            throw new Exception(mysqli_error($link));
        }
    }

    private function getQueryState() {
        if (mysqli_errno(Order::$connection) == 0) {
            // success
        } else {
            throw new Exception(mysqli_error(Order::$connection));
        }
    }

    public function deleteOrder() {
        if (isset(Order::$connection)) {
            if (isset($this->__receiptId)) {
                $query = "delete from product_order where receipt_id = '$this->__receiptId'";
                mysqli_query(Order::$connection, $query);
                $this->getQueryState();
            } else {
                throw new Exception("Receipt id has not been set");
            }
        } else {
            throw new Exception("Connection has not been established");
        }
    }

    public function load() {
        if (isset(Order::$connection)) {
            if (isset($this->__receiptId)) {
                $query = "select * from product_order where receipt_id = '$this->__receiptId'";
                $result = mysqli_query(Order::$connection, $query);

                $this->loadOrder(Order::$connection, $result);
            } else {
                throw new Exception("Receipt id has not been set");
            }
        } else {
            throw new Exception("Connection has not been established");
        }
    }

    public function save() {
        if (isset(Order::$connection)) {
            $query = "insert into product_order"
                    . " values('NULL','$this->__quantity','$this->__date','$this->__status','$this->__prdId','$this->__prdConfigId','$this->__custId','$this->__custTypeId','$this->__receiptId')";
            mysqli_query(Order::$connection, $query);

            if (mysqli_errno(Order::$connection) != 0) {
                throw new Exception(mysqli_error(Order::$connection));
            }
        } else {
            throw new Exception("Connection has not been established");
        }
    }

}
