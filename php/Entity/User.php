<?php
class User
{
    function __construct($values)
    {
        if (is_int(($values)))
        {
            $this->load_data($values);
        }
        else
        {
            # create user by params and add to database
        }
    }

    function load_data($id)
    {

    }

    function create_user()
    {

    }

    function delete_user()
    {

    }
}