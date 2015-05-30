<?php

/**
 * Created by PhpStorm.
 * User: Auser
 * Date: 2015/6/12
 * Time: 17:16
 */
class AdminModel extends CommonModel
{
    function admin()
    {
        $user = $this->one("select * from site");
        return $user;
    }

    function site()
    {
        $site = $this->one("select * from site");
        return $site;
    }

    function do_site($p)
    {
        $name = $p['name'];
        $surname = $p['surname'];
        $web_name = $p['web_name'];
        $ICP = $p['ICP'];
        $Copyright = $p['Copyright'];
        $email = $p['email'];
        $QQ = $p['QQ'];
        $tel = $p['tel'];
        $fax = $p['fax'];
        $weibo = $p['weibo'];
        echo $weibo;
        $this->db->query("update site set `name`='$name',`surname`='$surname',`web_name`='$web_name',`ICP`='$ICP',`Copyright`='$Copyright',`email`='$email',`QQ`='$QQ',`tel`='$tel',`fax`='$fax',`weibo`='$weibo'");
    }

    function create($p)
    {
        $username = trim($p['name']);
        $password = md5(trim($p['submit1']));
        $password1 = md5(trim($p['submit2']));
        $check = $this->one("select * from user where username = '$username' and password = '$password'");
        if ($check) {
            $this->db->query("update user set `password`='$password1' where `username` = '$username'");
            return true;
        } else {
            return false;
        }
    }

    function link()
    {
       // $username = $_SESSION["admin"];
        //$name = $username['username'];
        $link = $this->all("select * from link order by sort asc ");
        return $link;
    }

    function add($p)
    {
        $username = $_SESSION["admin"];
        $name = $username['username'];
        $web_name = $p['web_name'];
        $web_id = $p['web_id'];
        $this->db->query("insert into link(`username`,`web_name`,`web_id`)VALUES ('$name','$web_name','$web_id')");
    }

    function destroy($link_id)
    {
        for ($i = 0; $i < count($link_id); $i++) {
            $this->db->query("delete from link where id = '$link_id[$i]'");
        }
    }

    function sort($p)
    {
        $id = $p['id'];
        $sort = $p["sort"];
       foreach($sort as$k=> $v){
           $this->db->query("update link set `sort`='$v' where id = '$id[$k]'");

       }

    }

    function edit($p)
    {
        $web_name = $p['web_name'];
        $web_id = $p['web_id'];
        $id = $p['id'];
        $this->db->query("update link set `web_name`='$web_name',`web_id`= '$web_id' where id = '$id'");
    }

    function del($p)
    {
        $id = $p['id'];
        $this->db->query("delete from link where id = '$id'");
    }
}