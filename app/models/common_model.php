<?php
class CommonModel
{
    public $db;

    function __construct(){

        //模型常用方法, 数据库的操作
        $this->db = new mysqli(C("db_host"), C("db_username"), C("db_password"), C("db_name"));
        //检查连接错误
        if (mysqli_connect_errno()) {
            exit("连接失败: %s<br>". mysqli_connect_error());
        }
        $this->db->query("set names utf8");
        //指定表
    }

    /***
     * 查询所有数据
     * @param $sql
     * @return array
     */
    function all($sql){
        $result = $this->db->query($sql);
        $array = array();
        while($row = $result->fetch_assoc()){
            $array[] = $row;
        }
        return $array;
    }

    /***
     * 查询单条数据
     * @param $sql
     * @return mixed
     */
    function one($sql){
        $result = $this->db->query($sql);
        $row = $result->fetch_assoc();
        return $row;
    }

    /***
     * 查询符合条件的记录数
     * @param $sql
     * @return int
     */
    function count($table, $where=""){
        $result = $this->one("select count(*) as count from $table $where");
        return $result["count"];
    }

}