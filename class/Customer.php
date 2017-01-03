<?php

//require_once '../config.php';
require_once 'Person.php';

class Customer extends Person {

    private $_customerType;
    private $_customerTypeId;

    public function __construct($first, $last) {
        parent::__construct($first, $last);
    }

    static public function isUsed($username) {
        $count = 0;
        if (isset(Customer::$connection)) {
            $result = mysqli_query(Customer::$connection, "select * from customer where username='$username'");
            $count = mysqli_num_rows($result);
        } else {
            throw new Exception("Connection has not been established");
        }

        return $count;
    }

    public function setUsername($username) {
        if (Validate::username($username)) {
            if (Customer::isUsed($username) == 0) {
                $this->username = $username;
            } else {
                throw new Exception("Sorry, this username has been used. Try another one");
            }
        } else {
            throw new Exception("Sorry, your username is not valid");
        }
    }

    public function setCustomerTypeId($id) {
        $this->_customerTypeId = $id;
    }

    public function getCustomerTypeId() {
        return $this->_customerTypeId;
    }

    public function setCustomerType($cusType) {
        $this->_customerType = $cusType;
    }

    public function getCustomerType() {
        return $this->_customerType;
    }

    public function getAttr($field, $val, $searchParam = "") {
        
    }

    public function setAttr($field, $val, $searchParam = "") {
        
    }

    public function __autoload($className) {
        $class = str_replace("..", "", $className);
        require_once( "class/$class.php" );
    }

    public function usernameIsSet() {
        if (isset($this->username)) {
            return 1;
        } else {
            return 0;
        }
    }

    public function passwordIsSet() {
        if (isset($this->password)) {
            return 1;
        } else {
            return 0;
        }
    }

    private function loadCustomer($link, $result) {
        if (mysqli_errno($link) == 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $this->id = $row['customer_id'];
                $this->_customerTypeId = $row['customer_type_id'];
                $this->_customerType = $row['customer_type'];
                $this->surname = $row['surname'];
                $this->otherNames = $row['other_names'];
                $this->username = $row['username'];
                $this->password = $row['pass'];
                $this->email = $row['email'];
                $this->address = $row['address'];
            }
        } else {
            throw new Exception(mysqli_error($link));
        }
    }

    public function load() {
        if (isset(Customer::$connection)) {
            if ($this->usernameIsSet() && $this->passwordIsSet()) {

                $query = "select * from customer, customer_type where customer.username = '$this->username' and customer.pass = '$this->password' and customer.customer_type_id = customer_type.customer_type_id";
                $result = mysqli_query(Customer::$connection, $query);

                $this->loadCustomer(Customer::$connection, $result);
            } else {
                throw new Exception("Username / Password not set");
            }
        } else {
            throw new Exception("Connection has not been established");
        }
    }

    public function save() {
        if (isset(Customer::$connection)) {
            $query = "insert into customer "
                    . "values('NULL','$this->_customerTypeId','$this->surname','$this->otherNames','$this->username','$this->password','$this->phone','$this->email','$this->address')";
            mysqli_query(Customer::$connection, $query);

            if (mysqli_errno(Customer::$connection) != 0) {
                throw new Exception(mysqli_error(Customer::$connection));
            }
        } else {
            throw new Exception("Connection has not been established");
        }
    }

}
