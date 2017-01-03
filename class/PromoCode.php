<?php

/**
 * Description of PromoCode
 *
 * @author Abutu Justice Royale
 */
require_once 'Class.Validate.php';
require_once 'Discount.php';

class PromoCode extends Discount {

    private $ALPHA = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z');
    private $__numToGen;
    private $__minDiscount;
    private $__maxDiscount;
    private $__promoCode;
    private $__state;

    public function __construct($name) {
        parent::__construct($name);
        $this->__numToGen = 0;
        $this->__minDiscount = 0;
        $this->__maxDiscount = 0;
    }

    public function setPromoCode($promo) {
        if (Validate::promoCode($promo)) {
            $this->__promoCode = $promo;
        } else {
            throw new Exception("The promo code is invalid");
        }
    }

    public function setNumToGen($num) {
        if (Validate::number($num)) {
            $this->__numToGen = $num;
        } else {
            throw new Exception("The number to generate is invalid");
        }
    }

    public function getNumToGen() {
        return $this->__numToGen;
    }

    public function setMinDiscount($dis) {
        if (Validate::decimal($dis)) {
            $this->__minDiscount = $dis;
        } else {
            throw new Exception("The minimum discount is invalid");
        }
    }

    public function getMinDiscount() {
        return $this->__minDiscount;
    }

    public function setMaxDiscount($dis) {
        if (Validate::decimal($dis)) {
            $this->__maxDiscount = $dis;
        } else {
            throw new Exception("The maximum discount is invalid");
        }
    }

    public function getMaxDiscount() {
        return $this->__maxDiscount;
    }

    public function getPromoCode() {
        return $this->__promoCode;
    }

    private function generatePromoCode() {
        $tempP = "";
        $year = date("Y");

        for ($i = 1; $i <= 5; $i++) {
            $randAlpha = rand(0, 25);

            $tempP .= $this->ALPHA[$randAlpha];
        }
        for ($j = 1; $j <= 7; $j++) {
            $randNum = rand(1, 9);
            $tempP .= $randNum;
        }
        $this->__discount = rand($this->__minDiscount, $this->__maxDiscount);
        $this->__promoCode = $tempP . $year;
    }

    public function setState($st) {
        if (Validate::number($st)) {
            $this->__state = $st;
        } else {
            throw new Exception("Invalid state number");
        }
    }

    public function getState() {
        return $this->__state;
    }

    private function insertPromoCode($result) {
        if (PromoCode::getTotalRecords($result) == 1) {
            while ($row = mysqli_fetch_assoc($result)) {
                $this->__id = $row['discount_id'];
                $this->__typeId = $row["discount_type_id"];
            }

            for ($i = 1; $i <= $this->__numToGen; $i++) {
                $this->generatePromoCode($result);
                $query = "insert into promo_code"
                        . " values('NULL','$this->__promoCode','$this->__discount','$this->__state','$this->__id','$this->__typeId')";
                mysqli_query(PromoCode::$connection, $query);
            }
        } else {
            throw new Exception("Please enter a promo code discount");
        }
    }

    private function loadPromocode($result) {
        if (mysqli_errno(PromoCode::$connection) == 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $this->__id = $row['promo_code_id'];
                $this->__discount = $row['discount'];
                $this->__state = $row['state'];
            }
        } else {
            throw new Exception(mysqli_error(PromoCode::$connection));
        }
    }

    public function load() {
        if (isset(PromoCode::$connection)) {
            if (isset($this->__promoCode)) {
                $query = "select * from promo_code where promo_code = '$this->__promoCode'";
                $result = mysqli_query(PromoCode::$connection, $query);
                $this->loadPromocode($result);
                if($this->__state == 1){
                    throw new Exception("This promo code has been used.");
                }
            } else {
                throw new Exception("Promo code has not been set");
            }
        } else {
            throw new Exception("Connection has not been established");
        }
    }
    
    public function updateStatus() {
        if(isset($this->__id)){
            $query = "update promo_code set state = '1' where promo_code_id = '$this->__id'";
            mysqli_query(PromoCode::$connection, $query);
            if(mysqli_errno(PromoCode::$connection) != 0){
                throw new Exception(mysqli_error(PromoCode::$connection));
            }
        }
    }

    public function save() {
        if (isset(PromoCode::$connection)) {
            $today = date("Y-m-d h:m:s");
            $query = "select * from discount where discount_type_id = '$this->__typeId' and (end_date >= '$today' or end_date = '0000-00-00 00:00:00')";
            $result = mysqli_query(PromoCode::$connection, $query);

            if (mysqli_errno(PromoCode::$connection) != 0) {
                throw new Exception(mysqli_error(PromoCode::$connection));
            } else {
                $this->insertPromoCode($result);
            }
        } else {
            throw new Exception("Connection has not been established");
        }
    }

    static private function getTotalRecords($result) {
        return mysqli_num_rows($result);
    }

    static public function getJSONData($result) {
        $data = array();
        while ($row = mysqli_fetch_assoc($result)) {
            if ($row["state"] == 0) {
                $stat = "<label class='label label-success'>Available</label>";
            } else {
                $stat = "<label class='label label-danger'>Used</label>";
            }
            array_push($data, array("id" => "$row[discount_id]", "code" => "$row[promo_code]", "disType" => "$row[discount_type]", "discount" => "$row[discount]", "status" => $stat, "action" => "<a id='edit' href='#' title='edit' class='pull-left'><i class='fa fa-pencil'></i></a> <a id='delete' href='#' title='delete' class='pull-right'><i class='fa fa-times'></i></a>"));
        }
        return $data;
    }

    static public function getPromoCodes($dStart, $dLength, $sSortDir, $sEcho) {
        if (isset(PromoCode::$connection)) {
            $result = mysqli_query(PromoCode::$connection, "select * from discount, discount_type, promo_code where discount.discount_type_id = discount_type.discount_type_id and discount.discount_id = promo_code.discount_id");
            if (mysqli_errno(PromoCode::$connection) == 0) {
                $num = intval($sEcho);
                echo json_encode(array("sEcho" => "$num", "iTotalRecords" => PromoCode::getTotalRecords($result), "iTotalDisplayRecords" => PromoCode::getTotalRecords($result), "aaData" => PromoCode::getJSONData($result)));
            } else {
                throw new Exception(mysqli_error(PromoCode::$connection));
            }
        }
    }

}
