<?php

/**
 * Represents an Administrator, extends Person class
 * 
 * This class defines an admin; another user of the system. An admin may have a
 * title, qualification(s), staffId, password, and privillege 
 * @author Abutu Justice Royale
 */
require_once '../config.php';
require_once 'Person.php';

class Admin extends Person {

    private $_privillege;
    private $_privillege_id;

    public function __construct($first, $other) {
        parent::__construct($first, $other);
    }

    static public function isUsed($username) {
        $count = 0;
        if (isset(Admin::$connection)) {
            $result = mysqli_query(Admin::$connection, "select * from admin where username='$username'");
            $count = mysqli_num_rows($result);
        } else {
            throw new Exception("Connection has not been established");
        }

        return $count;
    }

    public function setUsername($username) {
        if (Validate::username($username)) {
            if (Admin::isUsed($username) == 0) {
                $this->username = $username;
            } else {
                throw new Exception("Sorry, this username has been used. Try another one");
            }
        } else {
            throw new Exception("Sorry, your username is not valid");
        }
    }

    public function setPrivilegeId($id) {
        $this->_privillege_id = $id;
    }

    public function getPrivilegeId() {
        return $this->_privillege_id;
    }

    public function setPrivilege($priv) {
        if (Validate::privilege($priv)) {
            $this->_privillege = $priv;
        }
    }

    public function getPrivilege() {
        return $this->_privillege;
    }

    static private function loadPrivileges($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<option value='" . $row['privilege_id'] . "'>" . $row['privilege'] . "</option>";
        }
    }

    static public function showPrivileges() {
        if (isset(Admin::$connection)) {
            $result = mysqli_query(Admin::$connection, "select * from privilege");
            if (mysqli_errno(Admin::$connection) == 0) {
                Admin::loadPrivileges($result);
            } else {
                throw new Exception(mysqli_error(Admin::$connection));
            }
        }
    }

    static public function getJSONData($result) {
        $data = array();
        while($row = mysqli_fetch_assoc($result)){
            array_push($data, array("id" => "$row[admin_id]", "fullname" => "$row[surname] $row[other_names]", "username" => "$row[username]", "access" => "$row[privilege]", "action" => "<a id='edit' href='#' title='edit' class='pull-left'><i class='fa fa-pencil'></i></a> <a id='delete' href='#' title='delete' class='pull-right'><i class='fa fa-times'></i></a>"));
        }
        return $data;
    }
    
    static private function getTotalRecords($result){
        return mysqli_num_rows($result);
    }

    static public function getAdmins($dStart, $dLength, $sSortDir, $sEcho) {
        if (isset(Admin::$connection)) {
            $result = mysqli_query(Admin::$connection, "select * from admin, privilege where admin.privilege_id = privilege.privilege_id");
            if (mysqli_errno(Admin::$connection) == 0) {
                $num = intval($sEcho);
               echo json_encode(array("sEcho" => "$num","iTotalRecords" => Admin::getTotalRecords($result), "iTotalDisplayRecords" => Admin::getTotalRecords($result), "aaData" => Admin::getJSONData($result)));
            } else {
                throw new Exception(mysqli_error(Admin::$connection));
            }
        }
    }

    /**
     * Loads required files automatically
     * 
     * @param string
     */
    public function __autoload($className) {
        $classObj = str_replace("..", "", $className);
        require_once "$classObj.php";
    }

    public function getAttr($field, $val, $searchParam = "") {
        
    }

    public function setAttr($field, $val, $searchParam = "") {
        
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
    
    public function isAdmin() {
        return isset($this->_privillege_id);
    }

    private function loadAdmin($link, $result) {
        if (mysqli_errno($link) == 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $this->id = $row['admin_id'];
                $this->_privillege_id = $row['privilege_id'];
                $this->_privillege = $row['privilege'];
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
        if (isset(Admin::$connection)) {
            if ($this->usernameIsSet() && $this->passwordIsSet()) {

                $query = "select * from admin, privilege where admin.username = '$this->username' and admin.pass = '$this->password' and admin.privilege_id = privilege.privilege_id";
                $result = mysqli_query(Admin::$connection, $query);

                $this->loadAdmin(Admin::$connection, $result);
            } else {
                throw new Exception("Username / Password not set");
            }
        } else {
            throw new Exception("Connection has not been established");
        }
    }

    public function save() {
        if (isset(Admin::$connection)) {
            $query = "insert into admin"
                    . " values('NULL','$this->_privillege_id','$this->surname','$this->otherNames','$this->username','$this->password','$this->phone','$this->email','$this->address')";
            mysqli_query(Admin::$connection, $query);

            if (mysqli_errno(Admin::$connection) != 0) {
                throw new Exception(mysqli_error(Admin::$connection));
            }
        } else {
            throw new Exception("Connection has not been established");
        }
    }

}
