<?php

//smarty配置
require(VENDOR_PATH . '/smarty/libs/Smarty.class.php');

class CommonController extends Smarty
{
    //当前方法对应的模板
    protected $template;
    protected $action;
    protected $controller;
    protected $model;

    function __construct()
    {
        parent::__construct();

        global $a, $c;
        $this->action = $a;
        $this->controller = $c;

        //smarty配置
        $this->set_smarty();

        //实例化模型
        $this->model = D();
        $this->check_login();
    }


    /***
     * smarty配置
     */
    private function set_smarty()
    {
        //模板的路径
        $this->setTemplateDir(APP_PATH . '/views/' . $this->controller);

        //编译模板位置
        $this->setCompileDir(APP_PATH . '/views/smarty/templates_c/');

        //配置文件路径
        $this->setConfigDir(APP_PATH . '/views/smarty/configs/');

        //缓存路径
        $this->setCacheDir(APP_PATH . '/views/smarty/cache/');

        $this->left_delimiter = "{{";
        $this->right_delimiter = "}}";


        //index.html
        $this->template = $this->action . ".html";
        $this->assign("assets", "/app/assets");
    }

    /***
     * 判断是否登录
     */
    function check_login()
    {
//        $allow = C("allow");
//        if($this->controller==$allow['c'] and in_array($this->action,$allow['a'])){
//            return true;
//        }
//        if(!isset($_SESSION['isAdmin'])){
//            $this->jump("index.php?control=user&action=login","请先登录！");
//            exit;
//        }
//        $this->assign("admin",$_SESSION["admin"]);
        if (isset($_SESSION["admin"])) {
            $this->assign("admin", $_SESSION["admin"]);
            return;

        }
        $allow = C("allow");
        if ($this->controller == $allow['c'] and in_array($this->action, $allow['a'])) {
            return true;
        }
        if (!isset($_COOKIE["token"])) {
            $this->jump("index.php?control=user&action=login", "请先登录！");
            exit;
        }
        $token = $_COOKIE['token'];
        $user = M();
        $check = $user->one("select * from user where token ='$token' ");
        if (!$check) {
            $this->jump("index.php?control=user&action=login", "请不要非法登录！");
            exit;
        }
        $_SESSION["admin"] = $check;
        $this->assign("admin", $_SESSION["admin"]);


    }




    // $s->display();
    /***
     * 重载smarty的display方法
     * @param null $template
     * @param null $cache_id
     * @param null $compile_id
     * @param null $parent
     */
    public function display($template = null, $cache_id = null, $compile_id = null, $parent = null)
    {
        $template = $template == "" ? $this->template : $template;
        parent::display($template, $cache_id = null, $compile_id = null, $parent = null);
    }


    /***
     * 清除session方法
     */
    protected function clearSession()
    {
        $_SESSION = array();
        if (isset($_COOKIE[session_name()])) {
            setcookie(session_name(), "", time() - 3600, "/");
        }
        setcookie("token", "", time() - 3600);
    }

    //成功信息
    protected function jump($url, $info = "")
    {
        if ($info == "") {
            echo "<script>location.href='" . $url . "'</script>";
        } else {
            echo "<script>alert('" . $info . "');location.href='" . $url . "'</script>";
        }
    }

}