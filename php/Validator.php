<?php
/**
 * Created by PhpStorm.
 * User: danielvarushchyk
 * Date: 3/3/18
 * Time: 04:44
 */

class Validator
{
    function validate($value, $type)
    {
        if (in_array($type, ["user_id", "organisation_id", "country_id", "city_id", "vacancy_id", "skill_id"]))
        {
            return $this->validate_id($value);
        }

        if (in_array($type, ["user_DOB", "employment_date_start", "employment_date_end", "qualification_date_start", "qualification_date_end"]))
        {
            return $this->validate_date($value);
        }

        if (in_array($type, ["skill_name", "qualification_name",  "vacancy_name", "city_name", "user_name", "user_surname", "employment_vacancy_name", "organisation_name", "country_name", "country_nationality"]))
        {
            return $this->validate_name($value);
        }

        if (in_array($type, ["user_sex", "qualification_type", "log_action_type"]))
        {
            return $this->validate_type($value);
        }

        if (in_array($type, ["user_admin"]))
        {
            return $this->validate_admin($value);
        }

        if (in_array($type, ["message_time", "log_time"]))
        {
            return $this->validate_timestamp($value);
        }

        if (in_array($type, ["organisation_description", "vacancy_description", "qualification_description"]))
        {
            return $this->validate_description($value);
        }

        if (in_array($type, ["message_text"]))
        {
            return $this->validate_text($value);
        }

        if (in_array($type, ["rights_code"]))
        {
            return $this->validate_code($value);
        }

        if (in_array($type, ["email"]))
        {
            return $this->validate_email($value);
        }

        if (in_array($type, ["password"]))
        {
            return $this->validate_password($value);
        }

        die("Error: unknown type to validate.");
    }
    private function validate_id($value)
    {
        return (is_numeric($value)) && (0 < $value && $value < 10000);
    }
    private function validate_date($value)
    {
        $value_list = explode("/", $value);
        if (sizeof($value_list) != 3)
        {
            return false;
        }
        return checkdate($value_list[1], $value_list[0], $value_list[2]);

    }
    private function validate_name($value)
    {
        $pattern = "/[a-zA-Z]{1,50}/";
        return boolval(preg_match($pattern, $value));
    }
    private function validate_type($value)
    {
        $pattern = "/[a-zA-Z]{1,20}/";
        return boolval(preg_match($pattern, $value));
    }
    private function validate_admin($value)
    {
        return is_bool($value);
    }
    private function validate_timestamp($value)
    {
        # TODO complete function!
        return true;
    }
    private function validate_description($value)
    {
        $pattern = "/[a-zA-Z]{1,1000}/";
        return boolval(preg_match($pattern, $value));
    }
    private function validate_text($value)
    {
        $pattern = "/[a-zA-Z]{1,5000}/";
        return boolval(preg_match($pattern, $value));
    }
    private function validate_code($value)
    {
        return (is_numeric($value)) && (0 < $value && $value < 10);
    }
    private function validate_email($value)
    {
        # TODO complete function!
        return true;
    }
    private function validate_password($value)
    {
        # TODO complete function!
        return true;
    }
}