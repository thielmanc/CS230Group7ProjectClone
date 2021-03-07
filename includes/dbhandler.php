<?php

// wrapper around the connection object generated when connecting to mysql db
// provides some convenience methods for executing prepared statements
class DBConnection {

    private $servename = "localhost";
    private $DBuname = "phpmyadmin";
    private $DBPass = "cs230lab"; // CHANGE AS NEEDED
    private $DBname = "cs230project";

    private $conn;

    function __construct() {
        $this->conn = mysqli_connect($this->servename, $this->DBuname, $this->DBPass, $this->DBname);
        if (!$this->conn)
            die("Connection failed...".mysqli_connect_error());
    }

    function __destruct() {
        // auto close DB connection when object is discarded
        mysqli_close($conn);
    }

    // executes a prepared query and returns an assoc array containing the FIRST ROW ONLY
    // good for fetching something from the DB by a unique identifier - ex. fetching a user by username, comment by id, etc.
    // use safe_stmt_exec if more than one row is needed or a more complex operation needs to be performed
    public function safe_query($query, $types, ...$params) {
        $stmt = mysqli_stmt_init($this->conn);
        mysqli_stmt_prepare($stmt, $query);
        mysqli_stmt_bind_param($stmt, $types, ...$params);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $data = mysqli_fetch_assoc($result);
        mysqli_stmt_close($stmt);
        return $data;
    }

    // executes a prepared statement and returns it
    public function safe_stmt_exec($query, $types, ...$params) {
        $stmt = mysqli_stmt_init($this->conn);
        mysqli_stmt_prepare($stmt, $query);
        mysqli_stmt_bind_param($stmt, $types, ...$params);
        mysqli_stmt_execute($stmt);
        return $stmt;
    }

    // execute query and return result without using prepared statements
    public function unsafe_query($query) {
        return mysqli_query($this->conn, $query);
    }

    // returns the connection object generated when connecting to the database
    // use when the above helper functions aren't sufficient and you need to pass the connection object directly to a mysqli_* func
    // note: you don't need to manually close the connection - it happens automatically when obj is garbage collected
    public function expose() {
        return $conn;
    }
}

