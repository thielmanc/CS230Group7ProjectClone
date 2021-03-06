<?php

class User {
    private $fname;
    private $lname;
    private $username;
    private $email;
    private $admin;

    function __construct($fname, $lname, $username, $email, bool $admin) {
        $this->fname = $fname;
        $this->lname = $lname;
        $this->username = $username;
        $this->email = $email;
        $this->admin = $admin;
    }

    public function first_name() {
        return $this->fname;
    }

    public function last_name() {
        return $this->fname;
    }

    public function full_name() {
        return "$this->fname $this->lname";
    }

    public function email() {
        return $this->fname;
    }

    public function is_admin() {
        return $this->admin;
    }
}