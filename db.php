<?php

require("config.php");

class Pilot
{
    private $id;
    private $name;
    private $surname;
    private $email;
    private $tel;
    private $image;

    public function __get($name)
    {
        return $this->$name;
    }

    public function __set($name, $value)
    {
        return $this->$name = $value;
    }

    public function index()
    {
        $mysqli = new mysqli(Config::DB_HOST, Config::DB_USER, Config::DB_PASS, Config::DB_DATABASE);
        $query = "SELECT * FROM pilots";
        $result = $mysqli->query($query);
        if($result)
        {
            $list = array();
            while($row = $result->fetch_assoc())
            {
                $obj = new Pilot();
                $obj->id = $row["id"];
                $obj->name = $row["name"];
                $obj->surname = $row["surname"];
                $obj->email = $row["email"];
                $obj->tel = $row["tel"];
                $obj->image = $row["image"];
                $list[] = $obj;
            }
            return $list;
        }
        $mysqli->close();
    }

    public function store()
    {
        $mysqli = new mysqli(Config::DB_HOST, Config::DB_USER, Config::DB_PASS, Config::DB_DATABASE);
        $query = "INSERT INTO pilots(name, surname, email, tel, image)
        VALUES(
            '" . $this->name . "',
            '" . $this->surname . "',
            '" . $this->email . "',
            '" . $this->tel . "',
            '" . $this->image . "'
        )";
        $mysqli->query($query);
        $this->id = $mysqli->insert_id;
        $mysqli->close();
    }

    public function edit()
    {
        $mysqli = new mysqli(Config::DB_HOST, Config::DB_USER, Config::DB_PASS, Config::DB_DATABASE);
        $query = "SELECT * FROM pilots WHERE id =" . $this->id;
        $result = $mysqli->query($query);
        if($row = $result->fetch_assoc())
        {
            $this->id = $row["id"];
            $this->name = $row["name"];
            $this->surname = $row["surname"];
            $this->email = $row["email"];
            $this->tel = $row["tel"];
            $this->image = $row["image"];
        }
        $mysqli->close();
    }

    public function update()
    {
        $mysqli = new mysqli(Config::DB_HOST, Config::DB_USER, Config::DB_PASS, Config::DB_DATABASE);
        $query = "UPDATE pilots SET
        name = '" . $this->name . "',
        surname = '" . $this->surname . "',
        email = '" . $this->email . "',
        tel = '" . $this->tel . "',
        image = '" . $this->image . "' WHERE id =" . $this->id;
        $mysqli->query($query);
        $mysqli->close();
    }

    public function destroy()
    {
        $mysqli = new mysqli(Config::DB_HOST, Config::DB_USER, Config::DB_PASS, Config::DB_DATABASE);
        $query = "DELETE FROM pilots WHERE id =" . $this->id;
        $mysqli->query($query);
        $mysqli->close();
    }
}

?>