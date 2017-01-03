<?php

/**
 * Description of Receipt
 *
 * @author Abutu Justice Royale
 */
class Receipt {

    private $__id;
    private $__price;
    private $__date;
    private $__deduct;
    static private $connection;

    public function __construct() {
        $this->__date = "0000-00-00 00:00:00";
    }

    public function setReceiptId($id) {
        if (Validate::number($id)) {
            $this->__id = $id;
        } else {
            throw new Exception("Receipt id is invalid");
        }
    }

    public function getReceiptId() {
        return $this->__id;
    }

    public function setReceiptPrice($price) {
        if (Validate::decimal($price)) {
            $this->__price = $price;
        } else {
            throw new Exception("Receipt price is invalid");
        }
    }

    public function getReceiptPrice() {
        return $this->__price;
    }

    public function setDate($date) {
        if (Validate::timestamp($date)) {
            $this->__date = $date;
        } else {
            throw new Exception("Receipt date is invalid");
        }
    }

    public function getDate() {
        return $this->__date;
    }

    public function setDeduct($d) {
        if (Validate::decimal($d) && ($d >= 0)) {
            $this->__deduct = $d;
        } else {
            throw new Exception("Receipt deduction is invalid");
        }
    }

    public function getDeduct() {
        return $this->__deduct;
    }

    static public function setConnection($host, $username, $password, $database) {
        Receipt::$connection = mysqli_connect($host, $username, $password, $database);

        if (mysqli_errno(Receipt::$connection) != 0) {
            throw new Exception(mysqli_error(Receipt::$connection));
        }
    }

    static public function getConnection() {
        if (isset(Receipt::$connection)) {
            return Receipt::$connection;
        } else {
            throw new Exception("Connection has not been established");
        }
    }

    public function updateReceipt() {
        if (isset(Receipt::$connection)) {
            if (isset($this->__id)) {
                // date paid is set to avoid auto update on that column
                $query = "update receipt "
                        . "set total_amount = '$this->__price', deduct = '$this->__deduct', date_paid = '0000-00-00 00:00:00' "
                        . "where receipt_id = '$this->__id'";
                mysqli_query(Receipt::$connection, $query);
                if (mysqli_errno(Receipt::$connection) == 0) {
                    // all went well
                } else {
                    throw new Exception(mysqli_error(Receipt::$connection));
                }
            } else {
                throw new Exception("Receipt id has not been set");
            }
        } else {
            throw new Exception("Connection has not been established");
        }
    }

    private function loadReceipt($link, $result) {
        if (mysqli_errno($link) == 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $this->__id = $row['receipt_id'];
                $this->__price = $row['total_amount'];
                $this->__deduct = $row['deduct'];
                $this->__date = $row['date_paid'];
            }
        } else {
            throw new Exception(mysqli_error($link));
        }
    }

    public function load() {
        if (isset(Receipt::$connection)) {
            if (isset($this->__id)) {
                $query = "select * from receipt where receipt_id = '$this->__id'";
                $result = mysqli_query(Receipt::$connection, $query);

                $this->loadReceipt(Receipt::$connection, $result);
            } else {
                throw new Exception("Receipt id has not been set");
            }
        } else {
            throw new Exception("Connection has not been established");
        }
    }

    public function save() {
        if (isset(Receipt::$connection)) {
            $query = "insert into receipt"
                    . " values('NULL','$this->__price','$this->__deduct','$this->__date')";
            mysqli_query(Receipt::$connection, $query);

            if (mysqli_errno(Receipt::$connection) == 0) {
                $this->__id = mysqli_insert_id(Receipt::$connection);
            } else {
                throw new Exception(mysqli_error(Receipt::$connection));
            }
        } else {
            throw new Exception("Connection has not been established");
        }
    }

}
