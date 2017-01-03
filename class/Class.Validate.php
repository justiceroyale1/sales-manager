<?php

/**
 * Validates user inputs
 *
 * This class defines static funtions that are used to validate users' input
 *
 * @author Abutu Justice Royale
 */
class Validate {

    /**
     * Sanitizes the post, and get input arrays.
     *
     * @return bool true if the sanitization was successful for any of
     * the input arrays.
     */
    static public function sanitize() {
        return filter_input_array(INPUT_GET) || filter_input_array(INPUT_GET);
    }

    /**
     * Perfoms some sanitization operations on an input
     *
     * @param int|string $input The input that would be sanitized
     * @return int|string The sanitized $input
     */
    static public function sanitizeInput($input) {
        $trimmed = trim($input);
        $squote = str_replace("'", "&rsquo;", $trimmed);
        $dquote = str_replace("\"", "", $squote);

        if (is_numeric($dquote)) {
            $sanitized = filter_var($trimmed, FILTER_SANITIZE_NUMBER_INT);
        } else {
            $html_encoded = htmlspecialchars($dquote);
            $strip = stripslashes($html_encoded);
            $sanitized = filter_var($strip, FILTER_SANITIZE_STRING);
        }

        return $sanitized;
    }
    
    static public function sanitizeImage($input) {
        $trimmed = trim($input);
        $squote = str_replace("'", "&rsquo;", $trimmed);
        $dquote = str_replace("..", "", "$squote");
        
        if (is_numeric($dquote)) {
            $sanitized = filter_var($trimmed, FILTER_SANITIZE_NUMBER_INT);
        } else {
            $html_encoded = htmlspecialchars($dquote);
            $strip = stripslashes($html_encoded);
            $sanitized = filter_var($strip, FILTER_SANITIZE_STRING);
        }

        return $sanitized;
    }

    /**
     * Checks if input is empty or not, returns true if input is
     * not empty, false otherwise
     *
     * @param int|string $check The input that would be checked
     * @return bool
     */
    static public function checkInput($check) {
        return (!empty(Validate::sanitizeInput($check)));
    }

    /**
     * Validates name strings. Returns true if name contains letters, hypen(-),
     * apostrophe('),space( ) and fullstop(.) only, and false otherwise.
     *
     * @param string $name The input to validate
     * @return bool True, if the validation was passed, false otherwise
     */
    static public function name($name) {
        $input = Validate::sanitizeInput($name);
        return preg_match("/^[A-Za-z \,\&\;\_\-\.]*?$/", $input);
    }

    /**
     * Validates date strings. Returns true if date is formatted thus:  
     * year-month-day, for example:
     * 
     * 29-12-2016
     * 02-03-2007
     *
     * @param string $date The input to validate
     * @return bool True, if the validation was passed, false otherwise
     */
    static public function date($date) {
        $input = Validate::sanitizeInput($date);
        return preg_match("/^[0-9]{4}\-[0-9]{2}\-[0-9]{2}*$/", $input);
    }
    
    static public function timestamp($ts) {
        $input = Validate::sanitizeInput($ts);
        return preg_match("/^([0-9]{4}\-[0-9]{2}\-[0-9]{2} [0-9]{2}:[0-9]{2}:[0-9]{2})*$/", $input);
    }

    /**
     * Validates username strings. Returns true if username contains letters, and
     * numbers only, and and is just 20 characters long, false otherwise.
     *
     * @param string $username The input to validate
     * @return bool True, if the validation was passed, false otherwise
     */
    static public function username($username) {
        $input = Validate::sanitizeInput($username);
        return preg_match("/^[A-Za-z0-9]{1,20}$/", $input);
    }

    /**
     * Validates address strings. Returns true if address contains letters, and
     * numbers, hyphens(-), commas(,), fullstops(.), forward slashes(/), 
     * backward slashes (\) and single qoutes(') only, false otherwise.
     *
     * @param string $username The input to validate
     * @return bool True, if the validation was passed, false otherwise
     */
    static public function address($address) {
        $input = Validate::sanitizeInput($address);
        return preg_match("/^([A-Za-z0-9 \_\-\.\,\&\;\/\\\])*?$/", $input);
    }

    // validate questions
    static public function question($question) {
        $input = Validate::sanitizeInput($question);
        return preg_match("/^([A-Za-z0-9 \?\_\-\.\,\&\;\/\\\])*?$/", $input);
    }

    /**
     * Validates strings. Returns true if strings contain fullstops, commas, letters and spaces 
     * only
     *
     * @param string $string The input to validate
     * @return bool True, if the validation was passed, false otherwise
     */
    static public function string($string) {
        $input = Validate::sanitizeInput($string);
        return preg_match("/^([A-Za-z\.\, ])*?$/", $input);
    }

    static public function year($year, $regex = "/^([0-9]{4})*?$/") {
        $input = Validate::sanitizeInput($year);
        return preg_match($regex, $input);
    }

    static public function answerOption($option, $regex = "/^[A-Z]?$/") {
        $input = Validate::sanitizeInput($option);
        return preg_match($regex, $input);
    }

    /**
     * Validates number strings. Returns true if numbers contains digits
     * only with no spaces in between, and false otherwise.
     *
     * @param string $num The input to validate
     * @return bool True, if the validation was passed, false otherwise
     */
    static public function number($num) {
        $input = Validate::sanitizeInput($num);
        return preg_match("/^\d+$/", $input);
    }

    /**
     * Validates phone number strings. Returns true if numbers contains digits
     * only with no spaces in between, and false otherwise
     *
     * @param string $num The input to validate
     * @return bool True, if the validation was passed, false otherwise
     */
    static public function phone($num) {
        $input = Validate::sanitizeInput($num);
        return preg_match("/("
                . "^([\(+1-9\)]{1,6}|[+1-9]{1,4}|[0]{1})" // (+234)/+234/0
                . "\s?"
                . "[0-9]{4}"
                . "\s?"
                . "[0-9]{0,3}"
                . "\s?"
                . "[0-9]{0,3})/x", $input);
    }

    /**
     * Validates email strings. Returns true if the input is a valid email, and
     * false otherwise
     *
     * @param strin $email The input string to validate
     * @return bool True, if the validation was passed, false otherwise
     */
    static public function email($email) {
        if (!empty(filter_var(Validate::sanitizeInput($email), FILTER_VALIDATE_EMAIL))) {
            return 1;
        } else {
            return 0;
        }
    }

    /**
     * Validates email strings. Returns true if the input is a valid email, and
     * false otherwise
     *
     * @param string $sex The input string to validate
     * @return bool True, if the validation was passed, false otherwise
     */
    static public function sex($sex, $regex = "/(^[Male]{1}|[Female]{1})$/") {
        $input = Validate::sanitizeInput($sex);
        return preg_match($regex, $input);
    }

    /**
     * Validates matriculation number strings. Returns true if the input is 10
     * digits long and does not begin with a zero(0), false otherwise
     *
     * @param string $matric The matriculation number to be validated
     * @param string $regex (optional) Validation rule
     * @return type bool
     */
    static public function matric($matric, $regex = "/^([1-9]{1})\d{9}$/") {
        $input = Validate::sanitizeInput($matric);
        return preg_match($regex, $input);
    }

    static public function employeePin($pin, $regex = "/^([A-Z]{2})\d{9}$/") {
        $input = Validate::sanitizeInput($pin);
        return preg_match($regex, $input);
    }

    /**
     * Validates pin strings. Returns true if the input meets the specified
     * rule, false otherwise
     *
     * @param string $pin The pin to be validated
     * @param string $regex (optional) Validation rule
     * @return bool
     */
    static public function pin($pin, $regex = "/^([1-9]{4})[0-9]{10}[A-Z]{2}$/") {
        $input = Validate::sanitizeInput($pin);
        return preg_match($regex, $input);
    }

    /**
     * Validates staffId strings. Returns true if the input meets the specified
     * rule, false otherwise
     *
     * @param string $staffId The staff id that has to be validated
     * @param string $regex (optional) Validation rule
     * @return bool
     */
    static public function staff($staffId, $regex = "/^([A-Za-z0-9])*?$/") {
        $input = Validate::sanitizeInput($staffId);
        return preg_match($regex, $input);
    }

    /**
     * Validates password strings. Returns true if the input meets the specified
     * rule, false otherwise
     *
     * @param string $password The password that has to be validated
     * @param string $regex (optional) Validation rule
     * @return bool
     */
    static public function password($password, $regex = "/^[0-9a-zA-Z]*$/") {
        $input = Validate::sanitizeInput($password);
        return preg_match($regex, $input);
    }

    /**
     * Validates activation codes strings.
     * @param string $code The code that has to be validated.
     * @return bool true if the code passes validation and false if it fails.
     */
    static public function activationCode($code) {
        $input = Validate::sanitizeInput($code);
        return preg_match("/^[RM|CD|BL|SF|SE]{2}[1-9]{4}[1-2]{1}[1-9MY]{2}[0-9]{1}[0-9]{2}$/", $input);
    }
    
    static public function promoCode($pc) {
        $input = Validate::sanitizeInput($pc);
        return preg_match("/^[A-Z]{5}[1-9]{7}[0-9]{4}$/", $input);
    }

    /**
     * Validates privilege strings. Returns true if the input meets the specified
     * rule, false otherwise
     *
     * @param string $privilege The privilege that has to be validated
     * @param string $regex (optional) Validation rule
     * @return bool
     */
    static public function privilege($privilege, $regex = "/^([a-z]{1})([1-9]{1})$/") {
        $input = Validate::sanitizeInput($privilege);
        return preg_match($regex, $input);
    }
    
    static public function image($image, $needle = "prd") {
        $input = Validate::sanitizeImage($image);
        return stristr($input, $needle);
    }


    /**
     * Validates courseCode strings. Returns true if the input meets the specified
     * rule, false otherwise
     *
     * @param string $courseCode The courseCode that needs to be validated
     * @param string $regex (optional) Validation rule
     * @return bool
     */
    static public function courseCode($courseCode, $regex = "/^([a-zA-Z]{3})([1-9]{3})$/") {
        $input = Validate::sanitizeInput($courseCode);
        return preg_match($regex, $input);
    }

    static public function decimal($dec) {
        if (Validate::sanitizeInput($dec) >= 0) {
            return true;
        } else {
            return false;
        }
    }

}
