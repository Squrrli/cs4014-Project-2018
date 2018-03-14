<?php
/**
 * All contacts to database will be made with this class
 * Functions either return [True, $some_data] either [False, $error_message]
 */
class Database
{
    private $filename = "php/DatabaseInfo";
    private $amount_of_rows_in_file = 4;
    private $name;
    private $login;
    private $password;
    private $hostname;
    private $connection;
    private $validator;
    function __construct()
    {
        $this->read_database_info();
        $this->connect();
        $this->validator = new Validator();
    }
    function __destruct()
    {
        $this->disconnect();
    }
    private function read_database_info()
    {
        if (!file_exists($this->filename)) {
            die("database file doesn't exist.");
        }
        $lines_of_file = file($this->filename);
        foreach ($lines_of_file as &$line_of_file) {
            $line_of_file = trim($line_of_file);
        }
        if (sizeof($lines_of_file) != $this->amount_of_rows_in_file) {
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

        if ($this->connection->connect_error) {
            die("Connection failed: " . $this->connection->connect_error);
        }
    }
    private function disconnect()
    {
        $this->connection->close();
    }
    public function add_user($values, $user_id_for_log)
    {
        $DOB = $values[0];
        $name = $values[1];
        $surname = $values[2];
        $sex = $values[3];
        $nationality = $values[4];
        $email = $values[5];
        $password = $values[6];
        $loc_country = $values[7];
        $loc_city = $values[8];
        $admin = $values[9];
        if (!$this->validator->validate_date($DOB)) {return [false, "invalid DOB"];}
        if (!$this->validator->validate_name($name)) {return [false, "invalid name"];}
        if (!$this->validator->validate_name($surname)) {return [false, "invalid surname"];}
        if (!$this->validator->validate_type($sex)) {return [false, "invalid id"];}
        if (!$this->validator->validate_id($nationality)) {return [false, "invalid nationality"];}
        if (!$this->validator->validate_email($email)) {return [false, "invalid email"];}
        if (!$this->validator->validate_password($password)) {return [false, "invalid password"];}
        if (!$this->validator->validate_id($loc_country)) {return [false, "invalid loc country"];}
        if (!$this->validator->validate_id($loc_city)) {return [false, "invalid loc city"];}
        if (!$this->validator->validate_admin($admin)) {return [false, "invalid admin"];}
        $var_names = "DOB, name, surname, sex, nationality, email, password, loc_country, loc_city, admin";
        $var_values = "'$DOB', '$name', '$surname', '$sex', $nationality, '$email', '$password', $loc_country, $loc_city, $admin";
        $sql = "INSERT INTO User ($var_names) VALUES ($var_values)";
        if ($this->connection->query($sql) === TRUE)
        {
            $this->add_log($user_id_for_log, "add user");
            return [true, null];
        }
        return [false, $this->connection->error];
    }
    public function remove_user($values, $user_id_for_log)
    {
        $id = $values[0];
        if (!$this->validator->validate_id($id)) {return [false, "invalid id"];}
        $sql = "DELETE FROM User WHERE id=$id";
        if ($this->connection->query($sql) === TRUE)
        {
            $this->add_log($user_id_for_log, "remove user", $id);
            return [true, null];
        }
        return [false, $this->connection->error];
    }
    public function update_user($values, $user_id_for_log)
    {
        $DOB = $values[0];
        $name = $values[1];
        $surname = $values[2];
        $sex = $values[3];
        $nationality = $values[4];
        $email = $values[5];
        $password = $values[6];
        $loc_country = $values[7];
        $loc_city = $values[8];
        $admin = $values[9];
        $id = $values[10];
        if (!$this->validator->validate_date($DOB)) {return [false, "invalid DOB"];}
        if (!$this->validator->validate_name($name)) {return [false, "invalid name"];}
        if (!$this->validator->validate_name($surname)) {return [false, "invalid surname"];}
        if (!$this->validator->validate_type($sex)) {return [false, "invalid id"];}
        if (!$this->validator->validate_id($nationality)) {return [false, "invalid nationality"];}
        if (!$this->validator->validate_email($email)) {return [false, "invalid email"];}
        if (!$this->validator->validate_password($password)) {return [false, "invalid password"];}
        if (!$this->validator->validate_id($loc_country)) {return [false, "invalid loc country"];}
        if (!$this->validator->validate_id($loc_city)) {return [false, "invalid loc city"];}
        if (!$this->validator->validate_admin($admin)) {return [false, "invalid admin"];}
        if (!$this->validator->validate_id($id)) {return [false, "invalid id"];}
        $sql = "UPDATE User SET DOB='$DOB', name='$name', surname='$surname', sex='$sex', nationality=$nationality, ";
        $sql .= "email='$email', password='$password', loc_country=$loc_country, loc_city=$loc_city, admin=$admin 'WHERE id=$id";
        if ($this->connection->query($sql) === TRUE)
        {
            $this->add_log($user_id_for_log, "update user", $id);
            return [true, null];
        }
        return [false, $this->connection->error];
    }
    public function get_user($values)
    {
        $id = $values[0];
        if (!$this->validator->validate_id($id)) {return [false, "invalid id"];}
        $sql = "SELECT id, DOB, name, surname,nationality, loc_country, loc_city FROM User WHERE id=$id";
        $result = $this->connection->query($sql);
        if ($result->num_rows == 1)
        {
            return [true, $result->fetch_assoc()];
        }
        return [false, "no result for this id"];
    }
    public function login($values)
    {
        $email = $values[0];
        $password = $values[0];
        if (!$this->validator->validate_email($email)) {return [false, "invalid email"];}
        if (!$this->validator->validate_password($password)) {return [false, "invalid password"];}
        $sql = "SELECT * FROM User WHERE email='$email', password='$password'";
        $result = $this->connection->query($sql);
        if ($result->num_rows == 1)
        {
            $to_return = $result->fetch_assoc();
            $this->add_log($to_return["id"], "login");
            return [true, $to_return];
        }
        return [false, "no result for this email and password"];
    }
    public function get_city($values)
    {
        $id = $values[0];
        if (!$this->validator->validate_id($id)) {return [false, "invalid id"];}
        $sql = "SELECT * FROM City WHERE id=$id";
        $result = $this->connection->query($sql);
        if ($result->num_rows == 1)
        {
            return [true, $result->fetch_assoc()];
        }
        return [false, "no result for this id"];
    }
    public function get_cities_by_country_id($values)
    {
        $country_id = $values[0];
        if (!$this->validator->validate_id($country_id)) {return [false, "invalid id"];}
        $sql = "SELECT * FROM City WHERE country_id=$country_id";
        $result = $this->connection->query($sql);
        if ($result->num_rows > 1)
        {
            $results = [];
            while ($row = $result->fetch_assoc())
            {
                array_push($results, $row);
            }
            return [true, $results];
        }
        return [false, "no result for this id"];
    }
    public function get_country($values)
    {
        $id = $values[0];
        if (!$this->validator->validate_id($id)) {return [false, "invalid id"];}
        $sql = "SELECT * FROM Country WHERE id=$id";
        $result = $this->connection->query($sql);
        if ($result->num_rows == 1)
        {
            return [true, $result->fetch_assoc()];
        }
        return [false, "no result for this id"];
    }
    public function get_countries()
    {
        $sql = "SELECT * FROM Country";
        $result = $this->connection->query($sql);
        if ($result->num_rows > 1)
        {
            $results = [];
            while ($row = $result->fetch_assoc())
            {
                array_push($results, $row);
            }
            return [true, $results];
        }
        return [false, "no results"];
    }
    public function add_employment($values, $user_id_for_log)
    {
        $user_id = $values[0];
        $date_start = $values[1];
        $date_end = $values[1];
        $organisation_name = $values[3];
        $organisation_id = $values[4];
        $vacancy_name = $values[5];
        $vacancy_id = $values[6];
        if (!$this->validator->validate_id($user_id)) {return [false, "invalid user id"];}
        if (!$this->validator->validate_date($date_start)) {return [false, "invalid start date"];}
        if (!$this->validator->validate_date($date_end)) {return [false, "invalid end date"];}
        if (!$this->validator->validate_name($organisation_name)) {return [false, "invalid organisation name"];}
        if (!$this->validator->validate_id($organisation_id)) {return [false, "invalid organisation id"];}
        if (!$this->validator->validate_id($vacancy_id)) {return [false, "invalid vacancy id"];}
        if (!$this->validator->validate_name($vacancy_name)) {return [false, "invalid vacancy name"];}

        $var_names = "user_id, date_start, date_end, organisation_name, organisation_id, vacancy_name, vacancy_id";
        $var_values = "$user_id, '$date_start', '$date_end', '$organisation_name', $organisation_id, '$vacancy_name', $vacancy_id";
        $sql = "INSERT INTO Employment ($var_names) VALUES ($var_values)";
        if ($this->connection->query($sql) === TRUE)
        {
            $this->add_log($user_id_for_log, "add employment");
            return [true, null];
        }
        return [false, $this->connection->error];
    }
    public function remove_employment($values, $user_id_for_log)
    {
        $id = $values[0];
        if (!$this->validator->validate_id($id)) {return [false, "invalid id"];}
        $sql = "DELETE FROM Employment WHERE id=$id";
        if ($this->connection->query($sql) === TRUE)
        {
            $this->add_log($user_id_for_log, "remove employment", $id);
            return [true, null];
        }
        return [false, $this->connection->error];
    }
    public function update_employment($values, $user_id_for_log)
    {
        $user_id = $values[0];
        $date_start = $values[1];
        $date_end = $values[1];
        $organisation_name = $values[3];
        $organisation_id = $values[4];
        $vacancy_name = $values[5];
        $vacancy_id = $values[6];
        $id = $values[7];
        if (!$this->validator->validate_id($user_id)) {return [false, "invalid user id"];}
        if (!$this->validator->validate_date($date_start)) {return [false, "invalid start date"];}
        if (!$this->validator->validate_date($date_end)) {return [false, "invalid end date"];}
        if (!$this->validator->validate_name($organisation_name)) {return [false, "invalid organisation name"];}
        if (!$this->validator->validate_id($organisation_id)) {return [false, "invalid organisation id"];}
        if (!$this->validator->validate_id($vacancy_id)) {return [false, "invalid vacancy id"];}
        if (!$this->validator->validate_name($vacancy_name)) {return [false, "invalid vacancy name"];}
        if (!$this->validator->validate_id($id)) {return [false, "invalid id"];}
        $sql = "UPDATE Employment SET user_id='$user_id', date_start='$date_start', date_end='$date_end', vacancy_name=$vacancy_name, ";
        $sql .= "organisation_name='$organisation_name', organisation_id='$organisation_id', vacancy_name=$vacancy_name, 'WHERE id=$id";
        if ($this->connection->query($sql) === TRUE)
        {
            $this->add_log($user_id_for_log, "update employment", $id);
            return [true, null];
        }
        return [false, $this->connection->error];
    }
    public function get_employments_by_user_id($values)
    {
        $user_id = $values[0];
        if (!$this->validator->validate_id($user_id)) {return [false, "invalid user id"];}
        $sql = "SELECT * FROM Employment WHERE user_id=$user_id";
        $result = $this->connection->query($sql);
        if ($result->num_rows > 1)
        {
            $results = [];
            while ($row = $result->fetch_assoc())
            {
                array_push($results, $row);
            }
            return [true, $results];
        }
        return [false, "no result for this id"];
    }
    public function add_message($values, $user_id_for_log)
    {
        $user1_id = $values[0];
        $user2_id = $values[1];
        $text = $values[2];
        if (!$this->validator->validate_id($user1_id)) {return [false, "invalid user1 id"];}
        if (!$this->validator->validate_id($user2_id)) {return [false, "invalid user2 id"];}
        if (!$this->validator->validate_text($text)) {return [false, "invalid text"];}

        $var_names = "user1_id, user2_id, text";
        $var_values = "$user1_id, $user2_id, '$text'";
        $sql = "INSERT INTO Message ($var_names) VALUES ($var_values)";
        if ($this->connection->query($sql) === TRUE)
        {
            $this->add_log($user_id_for_log, "add message");
            return [true, null];
        }
        return [false, $this->connection->error];
    }
    public function get_messages_by_user_id($values)
    {
        $user_id = $values[0];
        if (!$this->validator->validate_id($user_id)) {return [false, "invalid user id"];}
        $sql = "SELECT * FROM Message WHERE user_id=$user_id";
        $result = $this->connection->query($sql);
        if ($result->num_rows > 1)
        {
            $results = [];
            while ($row = $result->fetch_assoc())
            {
                array_push($results, $row);
            }
            return [true, $results];
        }
        return [false, "no result for this id"];
    }
    public function add_organisation($values, $user_id_for_log)
    {
        $name = $values[0];
        $description = $values[1];
        if (!$this->validator->validate_name($name)) {return [false, "invalid name"];}
        if (!$this->validator->validate_description($description)) {return [false, "invalid description"];}
        $var_names = "name, description";
        $var_values = "'$name', '$description'";
        $sql = "INSERT INTO Organisation ($var_names) VALUES ($var_values)";
        if ($this->connection->query($sql) === TRUE)
        {
            $this->add_log($user_id_for_log, "add organisation");
            return [true, null];
        }
        return [false, $this->connection->error];
    }
    public function remove_organisation($values, $user_id_for_log)
    {
        $id = $values[0];
        if (!$this->validator->validate_id($id)) {return [false, "invalid id"];}
        $sql = "DELETE FROM Organisation WHERE id=$id";
        if ($this->connection->query($sql) === TRUE)
        {
            $this->add_log($user_id_for_log, "remove organisation", $id);
            return [true, null];
        }
        return [false, $this->connection->error];
    }
    public function update_organisation($values, $user_id_for_log)
    {
        $name = $values[0];
        $description = $values[1];
        $id = $values[2];
        if (!$this->validator->validate_name($name)) {return [false, "invalid name"];}
        if (!$this->validator->validate_description($description)) {return [false, "invalid description"];}
        if (!$this->validator->validate_id($id)) {return [false, "invalid if"];}
        $sql = "UPDATE Organisation SET name='$name', description='$description' WHERE id=$id";
        if ($this->connection->query($sql) === TRUE)
        {
            $this->add_log($user_id_for_log, "update organisation", $id);
            return [true, null];
        }
        return [false, $this->connection->error];
    }
    public function get_organisation($values)
    {
        $id = $values[0];
        if (!$this->validator->validate_id($id)) {return [false, "invalid id"];}
        $sql = "SELECT * FROM Organisation WHERE id=$id";
        $result = $this->connection->query($sql);
        if ($result->num_rows == 1)
        {
            return [true, $result->fetch_assoc()];
        }
        return [false, "no result for this id"];
    }
    public function add_qualification($values, $user_id_for_log)
    {
        $user_id = $values[0];
        $date_start = $values[1];
        $date_end = $values[1];
        $name = $values[3];
        $description = $values[4];
        $type = $values[5];
        if (!$this->validator->validate_id($user_id)) {return [false, "invalid user id"];}
        if (!$this->validator->validate_date($date_start)) {return [false, "invalid start date"];}
        if (!$this->validator->validate_date($date_end)) {return [false, "invalid end date"];}
        if (!$this->validator->validate_name($name)) {return [false, "invalid organisation name"];}
        if (!$this->validator->validate_description($description)) {return [false, "invalid description"];}
        if (!$this->validator->validate_type($type)) {return [false, "invalid type"];}

        $var_names = "user_id, date_start, date_end, name, description, type";
        $var_values = "$user_id, '$date_start', '$date_end', '$name', '$description', '$type'";
        $sql = "INSERT INTO Qualification ($var_names) VALUES ($var_values)";
        if ($this->connection->query($sql) === TRUE)
        {
            $this->add_log($user_id_for_log, "add qualification");
            return [true, null];
        }
        return [false, $this->connection->error];
    }
    public function remove_qualification($values, $user_id_for_log)
    {
        $id = $values[0];
        if (!$this->validator->validate_id($id)) {return [false, "invalid id"];}
        $sql = "DELETE FROM Qualification WHERE id=$id";
        if ($this->connection->query($sql) === TRUE)
        {
            $this->add_log($user_id_for_log, "remove qualification", $id);
            return [true, null];
        }
        return [false, $this->connection->error];
    }
    public function update_qualification($values, $user_id_for_log)
    {
        $user_id = $values[0];
        $date_start = $values[1];
        $date_end = $values[1];
        $name = $values[3];
        $description = $values[4];
        $type = $values[5];
        $id = $values[6];
        if (!$this->validator->validate_id($user_id)) {return [false, "invalid user id"];}
        if (!$this->validator->validate_date($date_start)) {return [false, "invalid start date"];}
        if (!$this->validator->validate_date($date_end)) {return [false, "invalid end date"];}
        if (!$this->validator->validate_name($name)) {return [false, "invalid organisation name"];}
        if (!$this->validator->validate_id($id)) {return [false, "invalid id"];}
        if (!$this->validator->validate_description($description)) {return [false, "invalid description"];}
        if (!$this->validator->validate_type($type)) {return [false, "invalid type"];}
        $sql = "UPDATE Qualification SET user_id=$user_id, date_start='$date_start', date_end='$date_end', ";
        $sql .= "name='$name', description='$description', type='$type' WHERE id=$id";
        if ($this->connection->query($sql) === TRUE)
        {
            $this->add_log($user_id_for_log, "update qualification", $id);
            return [true, null];
        }
        return [false, $this->connection->error];
    }
    public function get_qualifications_by_user_id($values)
    {
        $user_id = $values[0];
        if (!$this->validator->validate_id($user_id)) {return [false, "invalid user id"];}
        $sql = "SELECT * FROM Qualification WHERE user_id=$user_id";
        $result = $this->connection->query($sql);
        if ($result->num_rows > 1)
        {
            $results = [];
            while ($row = $result->fetch_assoc())
            {
                array_push($results, $row);
            }
            return [true, $results];
        }
        return [false, "no result for this id"];
    }
    public function get_skill($values)
    {
        $id = $values[0];
        if (!$this->validator->validate_id($id)) {return [false, "invalid id"];}
        $sql = "SELECT * FROM Skill WHERE id=$id";
        $result = $this->connection->query($sql);
        if ($result->num_rows == 1)
        {
            return [true, $result->fetch_assoc()];
        }
        return [false, "no result for this id"];
    }
    public function get_skills()
    {
        $sql = "SELECT * FROM Skill";
        $result = $this->connection->query($sql);
        if ($result->num_rows > 1)
        {
            $results = [];
            while ($row = $result->fetch_assoc())
            {
                array_push($results, $row);
            }
            return [true, $results];
        }
        return [false, "no results"];
    }
    public function add_user_organisation($values, $user_id_for_log)
    {
        $user_id = $values[0];
        $organisation_id = $values[1];
        $rights = $values[2];
        if (!$this->validator->validate_id($user_id)) {return [false, "invalid user id"];}
        if (!$this->validator->validate_id($organisation_id)) {return [false, "invalid organisation id"];}
        if (!$this->validator->validate_type($rights)) {return [false, "invalid rights"];}
        $var_names = "user_id, organisation_id, rights";
        $var_values = "$user_id, $organisation_id, '$rights''";
        $sql = "INSERT INTO user_organisation ($var_names) VALUES ($var_values)";
        if ($this->connection->query($sql) === TRUE)
        {
            $this->add_log($user_id_for_log, "add user_organisation");
            return [true, null];
        }
        return [false, $this->connection->error];
    }
    public function remove_user_organisation($values, $user_id_for_log)
    {
        $user_id = $values[0];
        $organisation_id = $values[1];
        if (!$this->validator->validate_id($user_id)) {return [false, "invalid user id"];}
        if (!$this->validator->validate_id($organisation_id)) {return [false, "invalid organisation id"];}
        $sql = "DELETE FROM user_organisation WHERE user_id=$user_id AND organisation_id=$organisation_id";
        if ($this->connection->query($sql) === TRUE)
        {
            $this->add_log($user_id_for_log, "remove user_organisation (org_id)", $organisation_id);
            return [true, null];
        }
        return [false, $this->connection->error];
    }
    public function change_rights($values, $user_id_for_log)
    {
        $user_id = $values[0];
        $organisation_id = $values[1];
        $rights = $values[2];
        if (!$this->validator->validate_id($user_id)) {return [false, "invalid user id"];}
        if (!$this->validator->validate_id($organisation_id)) {return [false, "invalid organisation id"];}
        if (!$this->validator->validate_type($rights)) {return [false, "invalid rights"];}
        $sql = "UPDATE user_organisation SET rights=$rights WHERE user_id=$user_id AND organisation_id=$organisation_id";
        if ($this->connection->query($sql) === TRUE)
        {
            $this->add_log($user_id_for_log, "change rights(org_id)", $organisation_id);
            return [true, null];
        }
        return [false, $this->connection->error];
    }
    public function get_user_organisation_by_user_id($values)
    {
        $user_id = $values[0];
        if (!$this->validator->validate_id($user_id)) {return [false, "invalid user id"];}
        $sql = "SELECT * FROM user_organisation WHERE user_id=$user_id";
        $result = $this->connection->query($sql);
        if ($result->num_rows > 1)
        {
            $results = [];
            while ($row = $result->fetch_assoc())
            {
                array_push($results, $row);
            }
            return [true, $results];
        }
        return [false, "no result for this id"];
    }
    public function get_user_organisation_by_organisation_id($values)
    {
        $organisation_id = $values[0];
        if (!$this->validator->validate_id($organisation_id)) {return [false, "invalid organisation id"];}
        $sql = "SELECT * FROM user_organisation WHERE organisation_id=$organisation_id";
        $result = $this->connection->query($sql);
        if ($result->num_rows > 1)
        {
            $results = [];
            while ($row = $result->fetch_assoc())
            {
                array_push($results, $row);
            }
            return [true, $results];
        }
        return [false, "no result for this id"];
    }
    public function add_user_user($values, $user_id_for_log)
    {
        $user1_id = $values[0];
        $user2_id = $values[1];
        $text = $values[2];
        if (!$this->validator->validate_id($user1_id)) {return [false, "invalid user1 id"];}
        if (!$this->validator->validate_id($user2_id)) {return [false, "invalid user2 id"];}
        $var_names = "user1_id, user2_id";
        $var_values = "$user1_id, $user2_id";
        $sql = "INSERT INTO user_user ($var_names) VALUES ($var_values)";
        if ($this->connection->query($sql) === TRUE)
        {
            $this->add_log($user_id_for_log, "add user_user", $user2_id);
            return [true, null];
        }
        return [false, $this->connection->error];
    }
    public function remove_user_user($values, $user_id_for_log)
    {
        $id1 = $values[0];
        $id2 = $values[1];
        if (!$this->validator->validate_id($id1)) {return [false, "invalid id1"];}
        if (!$this->validator->validate_id($id2)) {return [false, "invalid id2"];}
        $sql = "DELETE FROM user_user WHERE (user1_id=$id1 AND user2_id=$id2) OR (user1_id=$id2 AND user2_id=$id1)";
        if ($this->connection->query($sql) === TRUE)
        {
            $this->add_log($user_id_for_log, "remove user_user", $id2);
            return [true, null];
        }
        return [false, $this->connection->error];
    }
    public function get_user_user_by_user_id($values)
    {
        $id = $values[0];
        if (!$this->validator->validate_id($id)) {return [false, "invalid id"];}
        $sql = "SELECT * FROM user_user WHERE user1_id=$id OR user2_id=$id";
        $result = $this->connection->query($sql);
        if ($result->num_rows > 1)
        {
            $results = [];
            while ($row = $result->fetch_assoc())
            {
                array_push($results, $row);
            }
            return [true, $results];
        }
        return [false, "no result for this id"];
    }
    public function add_user_skill($values, $user_id_for_log)
    {
        $user_id = $values[0];
        $skill_id = $values[1];
        if (!$this->validator->validate_id($user_id)) {return [false, "invalid user id"];}
        if (!$this->validator->validate_id($skill_id)) {return [false, "invalid skill id"];}
        $var_names = "user_id, skill_id";
        $var_values = "$user_id, $skill_id";
        $sql = "INSERT INTO user_skill ($var_names) VALUES ($var_values)";
        if ($this->connection->query($sql) === TRUE)
        {
            $this->add_log($user_id_for_log, "add user_skill(sk_id)", $skill_id);
            return [true, null];
        }
        return [false, $this->connection->error];
    }
    public function remove_user_skill($values, $user_id_for_log)
    {
        $user_id = $values[0];
        $skill_id = $values[1];
        if (!$this->validator->validate_id($user_id)) {return [false, "invalid user id"];}
        if (!$this->validator->validate_id($skill_id)) {return [false, "invalid skill id"];}
        $sql = "DELETE FROM user_skill WHERE user_id=$user_id AND skill_id=$skill_id";
        if ($this->connection->query($sql) === TRUE)
        {
            $this->add_log($user_id_for_log, "remove user_skill(sk_id)", $skill_id);
            return [true, null];
        }
        return [false, $this->connection->error];
    }
    public function get_user_skill_by_user_id($values)
    {
        $user_id = $values[0];
        if (!$this->validator->validate_id($user_id)) {return [false, "invalid user id"];}
        $sql = "SELECT * FROM user_skill WHERE user_id=$user_id";
        $result = $this->connection->query($sql);
        if ($result->num_rows > 1)
        {
            $results = [];
            while ($row = $result->fetch_assoc())
            {
                array_push($results, $row);
            }
            return [true, $results];
        }
        return [false, "no result for this id"];
    }
    public function add_vacancy($values, $user_id_for_log)
    {
        $organisation_id = $values[0];
        $name = $values[1];
        $city_id = $values[2];
        $description = $values[3];
        $id = $values[4];
        if (!$this->validator->validate_name($name)) {return [false, "invalid name"];}
        if (!$this->validator->validate_id($organisation_id)) {return [false, "invalid organisation id"];}
        if (!$this->validator->validate_id($city_id)) {return [false, "invalid city id"];}
        if (!$this->validator->validate_id($id)) {return [false, "invalid id"];}
        if (!$this->validator->validate_description($description)) {return [false, "invalid description"];}
        $var_names = "name, description, city_id, organisation_id";
        $var_values = "'$name', '$description', $city_id, $organisation_id";
        $sql = "INSERT INTO Vacancy ($var_names) VALUES ($var_values)";
        if ($this->connection->query($sql) === TRUE)
        {
            $this->add_log($user_id_for_log, "add vacancy(org_id)", $organisation_id);
            return [true, null];
        }
        return [false, $this->connection->error];
    }
    public function remove_vacancy($values, $user_id_for_log)
    {
        $id = $values[0];
        if (!$this->validator->validate_id($id)) {return [false, "invalid id"];}
        $sql = "DELETE FROM Vacancy WHERE id=$id";
        if ($this->connection->query($sql) === TRUE)
        {
            $this->add_log($user_id_for_log, "remove vacancy", $id);
            return [true, null];
        }
        return [false, $this->connection->error];
    }
    public function update_vacancy($values, $user_id_for_log)
    {
        $organisation_id = $values[0];
        $name = $values[1];
        $city_id = $values[2];
        $description = $values[3];
        $id = $values[4];
        if (!$this->validator->validate_name($name)) {return [false, "invalid name"];}
        if (!$this->validator->validate_id($organisation_id)) {return [false, "invalid organisation id"];}
        if (!$this->validator->validate_id($city_id)) {return [false, "invalid city id"];}
        if (!$this->validator->validate_id($id)) {return [false, "invalid id"];}
        if (!$this->validator->validate_description($description)) {return [false, "invalid description"];}
        $sql = "UPDATE Vacancy SET name='$name', organisation_id=$organisation_id, city_id=$city_id, description='$description' WHERE id=$id";
        if ($this->connection->query($sql) === TRUE)
        {
            $this->add_log($user_id_for_log, "update vacancy", $id);
            return [true, null];
        }
        return [false, $this->connection->error];
    }
    public function get_vacancy($values)
    {
        $id = $values[0];
        if (!$this->validator->validate_id($id)) {return [false, "invalid id"];}
        $sql = "SELECT * FROM Vacancy WHERE id=$id";
        $result = $this->connection->query($sql);
        if ($result->num_rows == 1)
        {
            return [true, $result->fetch_assoc()];
        }
        return [false, "no result for this id"];
    }
    public function get_vacancies_by_organisation_id($values)
    {
        $organisation_id = $values[0];
        if (!$this->validator->validate_id($organisation_id)) {return [false, "invalid organisation id"];}
        $sql = "SELECT * FROM vacancy_organisation WHERE organisation_id=$organisation_id";
        $result = $this->connection->query($sql);
        if ($result->num_rows > 1)
        {
            $results = [];
            while ($row = $result->fetch_assoc())
            {
                array_push($results, $row);
            }
            return [true, $results];
        }
        return [false, "no result for this id"];
    }
    public function add_vacancy_skill($values, $user_id_for_log)
    {
        $vacancy_id = $values[0];
        $skill_id = $values[1];
        $required = $values[2];
        if (!$this->validator->validate_id($skill_id)) {return [false, "invalid skill id"];}
        if (!$this->validator->validate_id($vacancy_id)) {return [false, "invalid vacancy id"];}
        if (!$this->validator->validate_admin($required)) {return [false, "invalid reuired(bool)"];}

        $var_names = "vacancy_id, vacancy_id, required";
        $var_values = "$vacancy_id, $vacancy_id, $required";
        $sql = "INSERT INTO vacancy_skill ($var_names) VALUES ($var_values)";
        if ($this->connection->query($sql) === TRUE)
        {
            $this->add_log($user_id_for_log, "add vacancy_skill(v_id)", $vacancy_id);
            return [true, null];
        }
        return [false, $this->connection->error];
    }
    public function remove_vacancy_skill($values, $user_id_for_log)
    {
        $vacancy_id = $values[0];
        $skill_id = $values[1];
        if (!$this->validator->validate_id($vacancy_id)) {return [false, "invalid vacancy id"];}
        if (!$this->validator->validate_id($skill_id)) {return [false, "invalid skill id"];}
        $sql = "DELETE FROM vacancy_skill WHERE vacancy_id=$vacancy_id AND skill_id=$skill_id";
        if ($this->connection->query($sql) === TRUE)
        {
            $this->add_log($user_id_for_log, "remove vacancy_skill(v_id)", $vacancy_id);
            return [true, null];
        }
        return [false, $this->connection->error];
    }
    public function get_vacancy_skill_by_vacancy_id($values)
    {
        $vacancy_id = $values[0];
        if (!$this->validator->validate_id($vacancy_id)) {return [false, "invalid vacancy id"];}
        $sql = "SELECT * FROM vacancy_skill WHERE vacancy_id=$vacancy_id";
        $result = $this->connection->query($sql);
        if ($result->num_rows > 1)
        {
            $results = [];
            while ($row = $result->fetch_assoc())
            {
                array_push($results, $row);
            }
            return [true, $results];
        }
        return [false, "no result for this id"];
    }
    public function change_required($values, $user_id_for_log)
    {
        $vacancy_id = $values[0];
        $skill_id = $values[1];
        $required = $values[2];
        if (!$this->validator->validate_id($skill_id)) {return [false, "invalid skill id"];}
        if (!$this->validator->validate_id($vacancy_id)) {return [false, "invalid vacancy id"];}
        if (!$this->validator->validate_admin($required)) {return [false, "invalid reuired(bool)"];}

        $sql = "UPDATE vacancy_skill SET required=$required WHERE vacancy_id=$vacancy_id AND skill_id=$skill_id";
        if ($this->connection->query($sql) === TRUE)
        {
            $this->add_log($user_id_for_log, "change required(v_id)", $vacancy_id);
            return [true, null];
        }
        return [false, $this->connection->error];
    }
    public function add_vacancy_user($values, $user_id_for_log)
    {
        $vacancy_id = $values[0];
        $user_id = $values[1];
        if (!$this->validator->validate_id($user_id)) {return [false, "invalid user id"];}
        if (!$this->validator->validate_id($vacancy_id)) {return [false, "invalid vacancy id"];}

        $var_names = "user_id, vacancy_id";
        $var_values = "$user_id, $vacancy_id";
        $sql = "INSERT INTO vacancy_user ($var_names) VALUES ($var_values)";
        if ($this->connection->query($sql) === TRUE)
        {
            $this->add_log($user_id_for_log, "add vacancy_user(v_id)", $vacancy_id);
            return [true, null];
        }
        return [false, $this->connection->error];
    }
    public function remove_vacancy_user($values, $user_id_for_log)
    {
        $user_id = $values[0];
        $vacancy_id = $values[1];
        if (!$this->validator->validate_id($user_id)) {return [false, "invalid user id"];}
        if (!$this->validator->validate_id($vacancy_id)) {return [false, "invalid vacancy id"];}
        $sql = "DELETE FROM user_vacancy WHERE user_id=$user_id AND vacancy_id=$vacancy_id";
        if ($this->connection->query($sql) === TRUE)
        {
            $this->add_log($user_id_for_log, "remove vacancy_user(v_id)", $vacancy_id);
            return [true, null];
        }
        return [false, $this->connection->error];
    }
    public function get_vacancy_user_by_user_id($values)
    {
        $user_id = $values[0];
        if (!$this->validator->validate_id($user_id)) {return [false, "invalid user id"];}
        $sql = "SELECT * FROM vacancy_user WHERE user_id=$user_id";
        $result = $this->connection->query($sql);
        if ($result->num_rows > 1)
        {
            $results = [];
            while ($row = $result->fetch_assoc())
            {
                array_push($results, $row);
            }
            return [true, $results];
        }
        return [false, "no result for this id"];
    }
    public function get_vacancy_user_by_vacancy_id($values)
    {
        $vacancy_id = $values[0];
        if (!$this->validator->validate_id($vacancy_id)) {return [false, "invalid vacancy id"];}
        $sql = "SELECT * FROM vacancy_user WHERE vacancy_id=$vacancy_id";
        $result = $this->connection->query($sql);
        if ($result->num_rows > 1)
        {
            $results = [];
            while ($row = $result->fetch_assoc())
            {
                array_push($results, $row);
            }
            return [true, $results];
        }
        return [false, "no result for this id"];
    }
    private function add_log($user_id, $action_type, $operated_on_id=null)
    {
        if (!$this->validator->validate_id($user_id)) {return [false, "invalid user1 id"];}
        if (!$this->validator->validate_id($action_type)) {return [false, "invalid user2 id"];}
        if (!$this->validator->validate_text($operated_on_id)) {return [false, "invalid text"];}
        $var_names = "user_id, action_type, operated_on_id";
        $var_values = "$user_id, '$action_type', '$operated_on_id'";
        $sql = "INSERT INTO Log ($var_names) VALUES ($var_values)";
        $this->connection->query($sql);
    }
}