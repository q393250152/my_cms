<?php
/*公共配置文件*/

header("Content-type:text/html;charset=utf-8");
require('config.php');//引用配置文件
session_start();//开启session


/*常量定义路径*/
defined("SITE_PATH") or define("SITE_PATH", getcwd());//定义项目路径
defined("APP_PATH") or define("APP_PATH", SITE_PATH . "/app"); //定义应用路径
defined("LIB_PATH") or define("LIB_PATH", SITE_PATH . "/lib");//定义自定义类路径
defined("PUBLIC_PATH") or define("PUBLIC_PATH", SITE_PATH . "/public");//定义公共资源路径
defined("VENDOR_PATH") or define("VENDOR_PATH", SITE_PATH . "/vendor");//定义第三方组件路径
/*路径定义结束*/

/*自动实例化并加载动作方法*/
$c = isset($_GET['control']) ? $_GET['control'] : "index";   //控制器
$a = isset($_GET['action']) ? $_GET['action'] : "index"; //方法、操作、动作


function autoload($classname)
{
    //自动加载控制器
    if(substr($classname, -10, 10) == "Controller") {
        $file = APP_PATH."/controllers/".strtolower(substr($classname, 0, -10))."_controller.php";
        if(is_file($file))
            require_once($file);
    }

    //自动加载模型
    if(substr($classname, -5, 5) == "Model") {
        $file = APP_PATH."/models/".strtolower(substr($classname, 0, -5))."_model.php";
        if(is_file($file))
            require_once($file);
    }
}


//注册自动加载函数
spl_autoload_register("autoload");

//实例化控制器，调用方法
$Controller = ucfirst($c)."Controller";

$controller = new $Controller();

$controller->$a();
/*自动实例化并加载动作方法结束*/


function M()
{
    //如果为指定模型, 那么就找对应当前控制器的模型
    $model = "CommonModel";
    //指定数据表c
    return new $model();
}

function  D()
{
    global $c;
    //如果为指定模型, 那么就找对应当前控制器的模型
    $model = ucfirst($c)."Model";

    //指定数据表c
    return new $model();
}

/***
 * 获取配置函数
 * @param $key
 * @return mixed
 */
function C($key)
{
    global $config;
    return $config["$key"];
}


/**
 * 打印函数
 * @param $arr
 */
function dump($arr)
{
    if (is_array($arr)) {
        echo '<pre>';
        print_r($arr);
        echo '</pre>';
    } else {
        echo $arr;
    }
}