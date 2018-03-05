<?php
/**
 * All contacts to database will be made with this class
 * Functions either return [True, $some_data] either [False, $error_message]
 */
class Database
{
    private $filename = "DatabaseInfo";
    private $amount_of_rows_in_file = 4;
    private $name;
    private $login;
    private $password;
    private $hostname;
    private $connection;
    function __construct()
    {
        $this->read_database_info();
        $this->connect();
    }
    private function read_database_info()
    {
        if(!file_exists($this->filename))
        {
            die("database file doesn't exist.");
        }
        $lines_of_file = file($this->filename);
        foreach ($lines_of_file as &$line_of_file)
        {
            $line_of_file = trim($line_of_file);
        }
        if (sizeof($lines_of_file) != $this->amount_of_rows_in_file)
        {
            die("incorrect amount of rows with data when reading database file.");
        }
        $this->login = $lines_of_file[0];
        $this->password = $lines_of_file[1];
        $this->hostname = $lines_of_file[2];
        $this->name = $lines_of_file[3];
    }
    private function connect()
    {
        $this->connection = new mysqli($this->hostname, $this->login, $this->password, $this->name);

        if ($this->connection->connect_error)
        {
            die("Connection failed: " . $this->connection->connect_error);
        }
    }
    private function disconnect()
    {
        $this->connection->close();
    }
    function login($email, $password)
    {
        # TODO complete function
        $sql = "SELECT * FROM User WHERE User.email = $email, User.password = $password";
        $result = $this->connection->query($sql);
        if ($result->num_rows == 1)
        {
            return [true, $result->fetch_assoc()];
        }
        else
        {
            return [false, "incorrect login or password."];
        }
    }
    function logout()
    {
        # TODO complete function
    }
    function add_user($user_info)
    {
        $DOB = $user_info[0];
        $name = $user_info[1];
        $surname = $user_info[2];
        $sex = $user_info[3];
        $nationality = $user_info[4];
        $email = $user_info[5];
        $password = $user_info[6];
        $loc_country = $user_info[7];
        $loc_city = $user_info[8];
        $admin = $user_info[9];
        $sql = "INSERT INTO User (DOB, name, surname, sex, nationality, email, password, loc_country, loc_city, admin) ";
        $sql .= "VALUES ($DOB, $name, $surname, $sex, $nationality, $email, $password, $loc_country, $loc_city, $admin)";
        if ($this->connection->query($sql) === true)
        {
            return [true, []];
        }
        else
        {
            return [false, $this->connection->error];
        }

    }
    function remove_user()
    {
        # TODO complete function
    }
    function change_user_info($login_info)
    {
        # TODO complete function
    }
    function search_user()
    {
        # TODO complete function
    }
    function add_friendship()
    {
        # TODO complete function
    }
    function add_message()
    {
        # TODO complete function
    }
    function get_messages()
    {
        # TODO complete function
    }
}