<?php

/**
 * Represents a user of the system
 * 
 * This class defines a person, which represents a user of the system. The person
 * may have a first name, middle name, last name, sex, email address,
 * and phone number.
 *
 * @author Abutu Justice Royale
 */
require_once 'Class.Validate.php';

abstract class Person {

    /**
     * @var string The person's first name 
     * @access protected
     */
    protected $surname;

    /**
     * @var string The person's last name
     * @access protected
     */
    protected $otherNames;

    /**
     * @var string The person's email
     * @access protected
     */
    protected $email;

    /**
     * @var string The person's phone number
     * @var protected
     */
    protected $phone;

    /**
     * @var int The person's id (corresponds to the id field in the database)
     * @access protected
     */
    protected $id;

    /**
     * @var resource The  connection to the database
     * @access protected
     */
    static protected $connection;
    protected $password;
    protected $username;
    protected $address;

    /**
     * Creates a new person
     * 
     * Creates a new person with values for all string attributes set to an
     * empty string
     * 
     * @return Person
     */
//    public function  __construct(){
//        $this->firstName = "";
//        $this->middleName = "";
//        $this->lastName = "";
//        $this->sex = "";
//        $this->email = "";
//        $this->phone = "";
//}

    /**
     * Creates a new Person object 
     * 
     * Creates a new person object with the arguments specified in each parameter
     * 
     * @param string $first The person's first name
     * @param string $middle The person's middle name
     * @param string $last The person's last name
     * @param string $s The person's sex (optional, default is empty string)
     * @param string $e The person's email (optional, default is empty string)
     * @param string $p The person's phone (optional, default is empty string)
     * @param array $_co Array containing references to a course object (optional, default is empty array)
     * @return Person
     */
    public function __construct($first, $last) {
        if (Validate::name($first) && (!empty($first))) {
            $this->surname = $first;
        } else {
            throw new Exception("Sorry, your first name is not valid");
        }

        if (Validate::name($last)) {
            $this->otherNames = $last;
        } else {
            throw new Exception("Sorry, other names are not valid");
        }
    }

    public function setSurname($name) {
        if (Validate::name($name) && (!empty($name))) {
            $this->surname = $name;
        } else {
            throw new Exception("Sorry, other names are not valid");
        }
    }

    /**
     * Sets the username of the person
     * 
     * @param string $username The username of the person
     * 
     * @return void
     */
    public function setUsername($username) {
        if (Validate::username($username)) {
            $this->username = $username;
        } else {
            throw new Exception("Sorry, your username is not valid");
        }
    }

    public function setLoginUsername($username) {
        if (Validate::username($username)) {
            $this->username = $username;
        } else {
            throw new Exception("Sorry, your username is not valid");
        }
    }

    /**
     * Sets the last name of the person
     * 
     * @param string $last The last name of the person
     * 
     * @return void
     */
    public function setOtherNames($last) {
        if (Validate::name($last)) {
            $this->otherNames = $last;
        } else {
            throw new Exception("Sorry, your other names are not valid");
        }
    }

    /**
     * Sets the email address of the person
     * 
     * @param string $e The email address of the person
     * 
     * @return void
     */
    public function setEmail($e) {
        if (Validate::email($e)) {
            $this->email = $e;
        } else {
            throw new Exception("Sorry, your email is not valid");
        }
    }

    public function setAddress($addr) {
        if (Validate::address($addr)) {
            $this->address = $addr;
        } else {
            throw new Exception("Sorry, your address is not valid");
        }
    }

    /**
     * Sets the phone number of the person
     * 
     * @param string $p The phone number of the person
     * 
     * @return void
     */
    public function setPhone($p) {
        if (Validate::phone($p)) {
            $needles = array("(", ")", " ");
            $phone = str_replace($needles, "", $p);
            if ($phone[0] == "0") {
                $new = "234" . substr($phone, 1);
            } else {
                $new = $phone;
            }
            $this->phone = $new;
        } else {
            throw new Exception("Sorry, your phone number is not valid");
        }
    }

    /**
     * Sets the id of the person
     * 
     * @return void
     */
    public function setId($i) {
        if (Validate::number($i)) {
            $this->id = $i;
        } else {
            throw new Exception("Sorry, your id is not valid");
        }
    }

    private function encrypt($pass) {
        $algo = "sha224";
        return hash($algo, $pass);
    }

    public function setPassword($pass) {
        if (Validate::password($pass)) {
            $this->password = $this->encrypt($pass);
        }
    }

    /**
     * Gets the first name of the person
     * 
     * @return string
     * @throws Exception If the first name of the person is empty
     */
    public function getSurname() {
        if (!empty($this->surname)) {
            return $this->surname;
        } else {
            throw new Exception("The first name of this person must be set");
        }
    }

    /**
     * Gets the last name of the person
     * 
     * @return string
     * @throws Exception If the last name of the person is empty
     */
    public function getOtherNames() {
        if (!empty($this->otherNames)) {
            return $this->otherNames;
        } else {
            throw new Exception("The last name of this person must be set");
        }
    }

    /**
     * Gets the email address of the person
     * 
     * @return string
     * @throws Exception If the email of the person is empty
     */
    public function getEmail() {
        if (!empty($this->email)) {
            return $this->email;
        } else {
            throw new Exception("The first name of this person must be set");
        }
    }

    /**
     * Gets the phone number of the person
     * 
     * @return string
     * @throws Exception If the phone number of the person is not set
     */
    public function getPhone() {
        if (!empty($this->phone)) {
            return $this->phone;
        } else {
            throw new Exception("The first name of this person must be set");
        }
    }

    /**
     * Gets the id of the person
     * 
     * @return int|string
     * @throws Exception If the id of the person if not set
     */
    public function getId() {
            return $this->id;
    }

    public function getPassword() {
        return $this->password;
    }

    public function getUsername() {
        return $this->username;
    }

    static public function setConnection($host, $username, $password, $database) {
        Person::$connection = mysqli_connect($host, $username, $password, $database);

        if (mysqli_errno(Person::$connection) != 0) {
            throw new Exception(mysqli_error(Person::$connection));
        }
    }

    static public function getConnection() {
        if (isset(Person::$connection)) {
            return Person::$connection;
        } else {
            throw new Exception("Connection has not been established");
        }
    }

    abstract public function load();

    abstract public function save();

    abstract public function getAttr($field, $val, $searchParam = "");

    abstract public function setAttr($field, $val, $searchParam = "");
}
