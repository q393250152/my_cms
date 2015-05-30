<?php

/**
 * Created by PhpStorm.
 * User: Auser
 * Date: 2015/6/12
 * Time: 17:15
 */
class AdminController extends CommonController
{
    function admin()
    {
        $user = $this->model->admin();
        $this->assign("user", $user);
        $this->display();
    }


    function modify()
    {
        $this->display();
    }

    function site()
    {
        $site = $this->model->site();
        $this->assign("site", $site);
        $this->display();
    }


    function create()
    {
        if ($_POST) {
            if ($this->model->create($_POST)) {
                $this->jump("index.php?control=admin&action=admin", "密码修改成功！");
            } else {
                $this->jump("index.php?control=admin&action=modify", "请检查帐号或密码是否正确！");
                exit;
            }

        }
    }

    function Clear_cache()
    {
        $this->display();
    }

    function link()
    {
        $link = $this->model->link();
        $this->assign("links", $link);
        $this->display();
    }

    function add()
    {
        if ($_POST) {
            $this->model->add($_POST);
            $this->jump("index.php?control=admin&action=link", "增加成功！");
        }
    }

    function destroy()
    {
        if ($_POST) {
            $link_id = $_POST["box2"];
            $this->model->destroy($link_id);
            $this->jump("index.php?control=admin&action=link", "删除成功！");
        }
    }

    function sort()
    {
        if ($_POST) {

            $this->model->sort($_POST);
            $this->jump("index.php?control=admin&action=link");
        }
    }

    function edit()
    {
        if ($_POST) {
            $this->model->edit($_POST);
            $this->jump("index.php?control=admin&action=link");
        }

    }

    function del()
    {
        if ($_POST) {
            $this->model->del($_POST);
            $this->jump("index.php?control=admin&action=link");
        }
    }

    function  do_site()
    {
        if ($_POST) {
            if (isset($_POST['cms'])) {
                $this->model->do_site($_POST);
                $this->jump("index.php?control=admin&action=site", "站点信息修改成功！");
            } else {
                $this->jump("index.php?control=admin&action=site", "您未同意使用协议！");
            }

        }
    }


}