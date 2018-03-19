<?php
class Validator
{
    public function validate_id($value)
    {
        $id_lower_limit = 0;
        $id_upper_limit = 10000;
        return (is_numeric($value)) && ($id_lower_limit < $value && $value < $id_upper_limit);
    }
    public function validate_date($value)
    {
        $value_list = explode("-", $value);
        # TODO move numbers here <--
        if (sizeof($value_list) != 3)
        {
            return false;
        }
        if ($value_list[2] > 31 || $value_list[2] < 0)
        {
            # TODO different amount of days for every month
            return false;
        }
        if ($value_list[1] > 12 || $value_list[1] < 0)
        {
            return false;
        }
        if ($value_list[0] > 2020 || $value_list[0] < 1900)
        {
            # TODO change to current year
            return false;
        }
        return true;

    }
    public function validate_name($value)
    {
        $pattern = "/^[a-zA-Z]{1,50}$/";
        return boolval(preg_match($pattern, $value));
    }
    public function validate_type($value)
    {
        $pattern = "/^[a-zA-Z]{1,20}$/";
        return boolval(preg_match($pattern, $value));
    }
    public function validate_admin($value)
    {
        return is_bool($value);
    }
    public function validate_timestamp($value)
    {
        # TODO complete function!
        return true;
    }
    public function validate_description($value)
    {
        $pattern = "/^.{1,1000}$/";
        return boolval(preg_match($pattern, $value));
    }
    public function validate_text($value)
    {
        $pattern = "/^.{1,5000}$/";
        return boolval(preg_match($pattern, $value));
    }
    public function validate_code($value)
    {
        return (is_numeric($value)) && (0 < $value && $value < 10);
    }
    public function validate_email($value)
    {
        $pattern = "/^[a-zA-Z0-9]{1,50}@[a-zA-Z0-9]{1,20}+\.[a-z]{2,}$/";
        return boolval(preg_match($pattern, $value));
    }
    public function validate_password($value)
    {
        $pattern = "/.{1,20}/";
        return boolval(preg_match($pattern, $value));
    }
}