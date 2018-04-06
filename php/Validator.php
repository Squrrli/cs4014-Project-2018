<?php
class Validator
{
    public function validate_id($value)
    {
        $value_num = $value + 0;
        $value_num .= "";
        # compare string with string of digits from initial string
        if ($value_num != $value)
        {
            return 0;
        }
        if ($value >= 0 && $value <= 9999999999)
        {
            return 1;
        }
        return 0;
    }
    public function validate_date($value)
    {
        $value_list = explode("-", $value);
        if (sizeof($value_list) != 3)
        {
            return 0;
        }
        if ($value_list[2] > 31 || $value_list[2] < 0)
        {
            return 0;
        }
        if ($value_list[1] > 12 || $value_list[1] < 0)
        {
            return 0;
        }
        if ($value_list[0] > 3000 || $value_list[0] < 1000)
        {
            return 0;
        }
        return 1;

    }
    public function validate_name($value)
    {
        if (strlen($value) <= 50 && strlen($value) > 0)
        {
            return 1;
        }
        return 0;
    }
    public function validate_type($value)
    {
        if (strlen($value) <= 20 && strlen($value) > 0)
        {
            return 1;
        }
        return 0;
    }
    public function validate_admin($value)
    {
        if ($value === "false" || $value === "true")
        {
            return 1;
        }
        return 0;
    }
    public function validate_timestamp($value)
    {
        #  TODO add later
        # we currently don't need timestamp so it's not here:)
        return 1;
    }
    public function validate_description($value)
    {
        if (strlen($value) <= 1000 && strlen($value) > 0)
        {
            return 1;
        }
        return 0;
    }
    public function validate_text($value)
    {
        if (strlen($value) <= 5000 && strlen($value) > 0)
        {
            return 1;
        }
        return 0;
    }
    public function validate_code($value)
    {
        $value_num = $value + 0;
        $value_num .= "";
        # compare string with string of digits from initial string
        if ($value_num != $value)
        {
            return 0;
        }
        if ($value >= 0 && $value <= 9)
        {
            return 1;
        }
        return 0;
    }
    public function validate_email($value)
    {
        $pattern = "/^[a-zA-Z0-9]{1,50}@[a-zA-Z0-9]{1,20}+\.[a-z]{2,}$/";
        return boolval(preg_match($pattern, $value));
    }
    public function validate_password($value)
    {
        if (strlen($value) <= 50 && strlen($value) > 0)
        {
            return 1;
        }
        return 0;
    }
}
# id: number(int or string) [0..999999999]
# date: string [1000..3000]-[0..12]-[0..31]
# name: any string of 1..50 length
# type: any string of 1..20 length
# admin/bool: string in array ["true", "false"]
# description: any string of 1..1000 length
# text: any string of 1..5000 length
# id: number(int or string) [0..9]
# email: string letter/number{1..50}@letter/number{1..q0}.letter/number{2..INF}";
# password: any string of 1..50 length