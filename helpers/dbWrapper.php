<?php
require_once 'connection.php';


class dbWrapper
{
    private $host;
    private $username;
    private $password;
    private $database;
    private $connection;

    public function __construct()
    {
        $this->host = DB_SERVER;
        $this->username = DB_USERNAME;
        $this->password = DB_PASSWORD;
        $this->database = DB_NAME;
    }

    public function connect()
    {
        $this->connection = new mysqli($this->host, $this->username, $this->password, $this->database);
                                        
        if ($this->connection->connect_errno) {
            die("Failed to connect to MySQL: " . $this->connection->connect_error);
        }
    }

    public function disconnect()
    {
        if ($this->connection) {
            $this->connection->close();
            $this->connection = null;
        }
    }

    public function query($sql)
    {   
        $result = $this->connection->query($sql);

        if (!$result) {
            die("Query failed: " . $this->connection->error);
        }

        return $result;
    }

    public function fetchArray($result)
    {
        return $result->fetch_assoc();
    }

    public function escapeString($value)
    {
        return $this->connection->real_escape_string($value);
    }

    public function executeQuery($sql)
{
    $this->connect();

    if (isset($sql) && !empty($sql)) {
        $result = $this->query($sql);

        if (!$result) {
            die("Query failed: " . $this->connection->error);
        }

        $array = $this->fetchArray($result);
        $this->disconnect();

        return $array;
    } else {
        die("Empty SQL query");
    }
}

public function executeSingleRowQuery($sql)
{
    $this->connect();

    if (isset($sql) && !empty($sql)) {
        $result = $this->query($sql);

        if (!$result) {
            die("Query failed: " . $this->connection->error);
        }

        $array = [];

        while ($row = mysqli_fetch_assoc($result)) {
            $array[] = $row;
        }

        $this->disconnect();

        return $array;
    } else {
        die("Empty SQL query");
    }
}

    public function executeUpdate($sql)
    {
        $this->connect();

        $success = $this->connection->query($sql);

        $this->disconnect();

        return $success;
    }

    public function executeQueryAndReturnId($sql)
    {
        $this->connect();

        $success = $this->connection->query($sql);

        if (!$success) {
            die("Query execution failed: " . $this->connection->error);
        }

        $insertId = $this->connection->insert_id;

        $this->disconnect();

        return $insertId;
    }
}
