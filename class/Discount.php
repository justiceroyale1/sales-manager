<?php

/**
 *
 * @author Abutu Justice Royale
 */
require_once '../config.php';
require_once 'Class.Validate.php';

class Discount {

    protected $__id;
    private $__name;
    private $__amount;
    protected $__date;
    protected $__discount;
    protected $__startTS;
    protected $__endTS;
    protected $__typeId;
    protected $__type;
    protected $__numOfPrd;
    static protected $connection;

    public function __construct($name) {
        if (Validate::name($name) && (!empty($name))) {
            if (Discount::isUsed($name) == 0) {
                $this->__name = $name;
            } else {
                throw new Exception("Sorry, this name has been used. Try another one");
            }
        } else {
            throw new Exception("Sorry, discount name is not valid");
        }
        $this->__date = date("Y-m-d h:m:s");
        $this->__discount = 0;
    }

    public function setDisId($id) {
        if (Validate::number($id)) {
            $this->__id = $id;
        } else {
            throw new Exception("Sorry, product id is invalid");
        }
    }

    public function getDisId() {
        return $this->__id;
    }

    public function setDisName($name) {
        if (Validate::name($name) && (!empty($name))) {
            if (Discount::isUsed($name) == 0) {
                $this->__name = $name;
            } else {
                throw new Exception("Sorry, this name has been used. Try another one");
            }
        } else {
            throw new Exception("Sorry, discount name is not valid");
        }
    }

    public function getDisName() {
        return $this->__name;
    }

    public function setDisAmount($amount) {
        if (Validate::decimal($amount)) {
            $this->__amount = $amount;
        } else {
            throw new Exception("Sorry, discount amount is not valid");
        }
    }

    public function getDisAmount() {
        return $this->__amount;
    }

    public function setDiscount($discount) {
        if (Validate::decimal($discount)) {
            $this->__discount = $discount;
        } else {
            throw new Exception("Sorry, discount is not valid");
        }
    }

    public function getDiscount() {
        return $this->__discount;
    }

    public function setStartTimestamp($ts) {
        if (Validate::timestamp($ts)) {
            $this->__startTS = $ts;
        } else {
            throw new Exception("Sorry, timestamp is not valid");
        }
    }

    public function getStartTimestamp() {
        return $this->__startTS;
    }

    public function setEndTimestamp($ts) {
        if (Validate::timestamp($ts)) {
            $this->__endTS = $ts;
        } else {
            throw new Exception("Sorry, timestamp is not valid");
        }
    }

    public function getEndTimestamp() {
        return $this->__endTS;
    }

    public function setDiscountTypeId($id) {
        if (Validate::number($id)) {
            $this->__typeId = $id;
        } else {
            throw new Exception("Sorry, product id is invalid");
        }
    }

    public function getDiscountTypeId() {
        return $this->__typeId;
    }

    public function setDiscountType($dt) {
        if (Validate::name($dt) && (!empty($dt))) {
            $this->__type = $dt;
        } else {
            throw new Exception("Sorry, discount type is not valid");
        }
    }

    public function getDiscounttype() {
        return $this->__type;
    }

    public function setNumOfPrd($num) {
        if (Validate::number($num)) {
            $this->__numOfPrd = $num;
        } else {
            throw new Exception("Sorry, number of products entered is not valid");
        }
    }

    public function getNumOfPrd() {
        return $this->__numOfPrd;
    }

    static public function setConnection($host, $username, $password, $database) {
        Discount::$connection = mysqli_connect($host, $username, $password, $database);

        if (mysqli_errno(Discount::$connection) != 0) {
            throw new Exception(mysqli_error(Discount::$connection));
        }
    }

    static public function getConnection() {
        if (isset(Discount::$connection)) {
            return Discount::$connection;
        } else {
            throw new Exception("Connection has not been established");
        }
    }

    static public function isUsed($name) {
        $count = 0;
        if (isset(Discount::$connection)) {
            $result = mysqli_query(Discount::$connection, "select * from discount where discount_name='$name'");
            $count = mysqli_num_rows($result);
        } else {
            throw new Exception("Connection has not been established");
        }

        return $count;
    }

    private function loadDiscount($link, $result) {
        if (mysqli_errno($link) == 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $this->__id = $row['discount_id'];
                $this->__name = $row['discount_name'];
                $this->__numOfPrd = $row['num_of_products'];
                $this->__discount = $row['discount'];
                $this->__startTS = $row['start_date'];
                $this->__endTS = $row['end_date'];
                $this->__typeId = $row['discount_type_id'];
                $this->__type = $row['discount_type'];
            }
        } else {
            throw new Exception(mysqli_error($link));
        }
    }

    public function load() {
        if (isset(Discount::$connection)) {
            if (isset($this->__date) && isset($this->__numOfPrd)) {
                $query = "select * from discount, discount_type where num_of_products <= '$this->__numOfPrd' "
                        . "and discount.discount_type_id = discount_type.discount_type_id "
                        . "and (end_date >= '$this->__date' or end_date = '0000-00-00 00:00:00') "
                        . "and discount.discount_type_id = '1' limit 1";
                $result = mysqli_query(Discount::$connection, $query);

                $this->loadDiscount(Discount::$connection, $result);
            } else {
                throw new Exception("Discount number of products has not been set");
            }
        } else {
            throw new Exception("Connection has not been established");
        }
    }

    public function save() {
        if (isset(Discount::$connection)) {
            $query = "insert into discount"
                    . " values('NULL','$this->__name','$this->__discount','$this->__startTS','$this->__endTS','$this->__typeId','$this->__numOfPrd')";
            mysqli_query(Discount::$connection, $query);

            if (mysqli_errno(Discount::$connection) != 0) {
                throw new Exception(mysqli_error(Discount::$connection));
            }
        } else {
            throw new Exception("Connection has not been established");
        }
    }

    static private function loadDiscountTypes($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<option value='" . $row['discount_type_id'] . "'>" . $row['discount_type'] . "</option>";
        }
    }

    static public function showDiscountTypes() {
        if (isset(Discount::$connection)) {
            $result = mysqli_query(Discount::$connection, "select * from discount_type");
            if (mysqli_errno(Discount::$connection) == 0) {
                Discount::loadDiscountTypes($result);
            } else {
                throw new Exception(mysqli_error(Discount::$connection));
            }
        }
    }

    static public function getJSONData($result) {
        $data = array();
        while ($row = mysqli_fetch_assoc($result)) {
            if ($row['start_date'] == "0000-00-00 00:00:00") {
                $start = "<label class='label label-info'>Forever</label>";
            } else {
                $start = $row["start_date"];
            }
            if ($row['end_date'] == "0000-00-00 00:00:00") {
                $end = "<label class='label label-info'>Forever</label>";
            } else {
                $end = $row["end_date"];
            }
            array_push($data, array("id" => "$row[discount_id]", "name" => "$row[discount_name]", "disType" => $row["discount_type"], "NOP" => number_format($row["num_of_products"]), "discount" => number_format($row["discount"], '2'), "start" => $start, "end" => $end, "action" => "<a id='edit' href='#' title='edit' class='pull-left'><i class='fa fa-pencil'></i></a> <a id='delete' href='#' title='delete' class='pull-right'><i class='fa fa-times'></i></a>"));
        }
        return $data;
    }

    static private function getTotalRecords($result) {
        return mysqli_num_rows($result);
    }

    static public function getDiscounts($dStart, $dLength, $sSortDir, $sEcho) {
        if (isset(Discount::$connection)) {
            $result = mysqli_query(Discount::$connection, "select * from discount, discount_type where discount.discount_type_id = discount_type.discount_type_id");
            if (mysqli_errno(Discount::$connection) == 0) {
                $num = intval($sEcho);
                echo json_encode(array("sEcho" => "$num", "iTotalRecords" => Discount::getTotalRecords($result), "iTotalDisplayRecords" => Discount::getTotalRecords($result), "aaData" => Discount::getJSONData($result)));
            } else {
                throw new Exception(mysqli_error(Admin::$connection));
            }
        }
    }

}
