<?php
class Validator
{
    function validate($value, $type)
    {
        if (in_array($type, ["user_id", "organisation_id", "country_id", "city_id", "vacancy_id", "skill_id"]))
        {
            echo("that's an id");
            return $this->validate_id($value);
        }

        if (in_array($type, ["user_DOB", "employment_date_start", "employment_date_end", "qualification_date_start", "qualification_date_end"]))
        {
            echo("that's a date");
            return $this->validate_date($value);
        }

        if (in_array($type, ["skill_name", "qualification_name",  "vacancy_name", "city_name", "user_name", "user_surname", "employment_vacancy_name", "organisation_name", "country_name", "country_nationality"]))
        {
            echo("that's a name");
            return $this->validate_name($value);
        }

        if (in_array($type, ["user_sex", "qualification_type", "log_action_type"]))
        {
            echo("that's a type");
            return $this->validate_type($value);
        }

        if (in_array($type, ["user_admin"]))
        {
            echo("that's an admin bool");
            return $this->validate_admin($value);
        }

        if (in_array($type, ["message_time", "log_time"]))
        {
            echo("that's a timestamp");
            return $this->validate_timestamp($value);
        }

        if (in_array($type, ["organisation_description", "vacancy_description", "qualification_description"]))
        {
            echo("that's a description");
            return $this->validate_description($value);
        }

        if (in_array($type, ["message_text"]))
        {
            echo("that's a text");
            return $this->validate_text($value);
        }

        if (in_array($type, ["rights_code"]))
        {
            echo("that's an rights code");
            return $this->validate_code($value);
        }

        if (in_array($type, ["user_email"]))
        {
            echo("that's an email");
            return $this->validate_email($value);
        }

        if (in_array($type, ["user_password"]))
        {
            echo("that's a password");
            return $this->validate_password($value);
        }

        die("Error: unknown type to validate.");
    }
    private function validate_id($value)
    {
        $id_lower_limit = 0;
        $id_upper_limit = 10000;
        return (is_numeric($value)) && ($id_lower_limit < $value && $value < $id_upper_limit);
    }
    private function validate_date($value)
    {
        $value_list = explode("/", $value);
        # TODO move numbers here <--
        if (sizeof($value_list) != 3)
        {
            return false;
        }
        if ($value_list[0] > 31 || $value_list[0] < 0)
        {
            # TODO different amount of days for every month
            return false;
        }
        if ($value_list[1] > 12 || $value_list[1] < 0)
        {
            return false;
        }
        if ($value_list[2] > 2020 || $value_list[2] < 1900)
        {
            # TODO change to current year
            return false;
        }
        return true;

    }
    private function validate_name($value)
    {
        $pattern = "/^[a-zA-Z]{1,50}$/";
        return boolval(preg_match($pattern, $value));
    }
    private function validate_type($value)
    {
        $pattern = "/^[a-zA-Z]{1,20}$/";
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
        $pattern = "/^.{1,1000}$/";
        return boolval(preg_match($pattern, $value));
    }
    private function validate_text($value)
    {
        $pattern = "/^.{1,5000}$/";
        return boolval(preg_match($pattern, $value));
    }
    private function validate_code($value)
    {
        return (is_numeric($value)) && (0 < $value && $value < 10);
    }
    private function validate_email($value)
    {
        $pattern = "/^[a-zA-Z0-9]{1,50}@[a-zA-Z0-9]{1,20}+\.[a-z]{2,}$/";
        return boolval(preg_match($pattern, $value));
    }
    private function validate_password($value)
    {
        $pattern = "/.{1,20}/";
        return boolval(preg_match($pattern, $value));
    }
}