<?php
/**
 * Created by PhpStorm.
 * User: Winnerawan T
 * Date: 9/20/2016
 * Time: 8:12 PM
 */

include '../lib/Session.php';
Session::checkLogin();
include_once '../lib/Database.php';
include_once '../helper/Format.php';
?>

<?php

class Adminlogin {

    private $db;
    private $fm;
    public function __construct() {
        $this->db=new Database();
        $this->fm=new Format();
    }

    public function adminLogin($username, $password) {
        $username = $this->fm->validation($username);
        $password = $this->fm->validation($password);

        $username = mysqli_real_escape_string($this->db->link, $username);
        $password = mysqli_real_escape_string($this->db->link, $password);

        if(empty($username) || empty($password)) {
            $loginmsg = "Username atau Password tidak boleh kosong !";
            return $loginmsg;
        } else {
            $query = "SELECT * FROM tbl_admin WHERE username = '$username' AND password = '$password'";
            $result = $this->db->select($query);

            if($result!=false) {
                $value = $result->fetch_assoc();
                Session::set("adminlogin", true);
                Session::set("admin_id", $value['admin_id']);
                Session::set("username", $value['username']);
                Session::set("admin_name", $value['admin_name']);
                header('Location:dashboard.php');
            } else {
                $loginmsg = "Username atau Password salah !";
                return $loginmsg;
            }
        }
    }

}
