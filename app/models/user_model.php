<?php
/**
 * Created by PhpStorm.
 * User: Auser
 * Date: 2015/6/12
 * Time: 15:31
 */
class UserModel extends CommonModel{
    function create($p){
        $username =trim( $p['username']);
        $password = md5(trim($p['password']));
        $token = md5($username.$password.rand(500,30000).time());
        $user = $this->one("select * from user where username = '$username'");
        if(!$user){
            $this->db->query("insert into user (`username`,`password`,`token`)values('$username','$password','$token')");
            return true;
        }else{
            return false;
        }

    }
    function do_login($p){
        $username =trim($p['username']);
        $password = md5(trim($p['password']));
        $check = $this->one("select * from user where username = '$username' and password = '$password'");
        if($check){

//            $_SESSION["isAdmin"] = 1;
            if(isset($p['checkbox'])){
                setcookie("token",$check['token'],time()+60*5);
            }else{
                setcookie("token",$check['token']);
            }
            return true;
        }else{
            return false;
        }
    }
}
