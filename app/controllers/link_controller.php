<?php

/**
 * Created by PhpStorm.
 * User: Auser
 * Date: 2015/6/20
 * Time: 21:32
 */
class LinkController extends CommonController
{
    function article()
    {
        $article = $this->model->article();
        $this->assign("articles", $article);
        $this->display();
    }

    function article_add()
    {
        if ($_POST) {
            $this->model->article_add($_POST);
            $this->jump("index.php?control=link&action=article_add");
        }
        $titles = $this->model->title_add();
        $this->assign("titles", $titles);
        $time = $this->model->time();
        $this->assign("time", $time);
        $this->display();
    }

    function destroy()
    {
        if ($_POST) {
            $id = $_POST['box2'];
            $this->model->destroy($id);
            $this->jump("index.php?control=link&action=article");
        }
    }

    function article_edit()
    {
        $id = $_GET['id'];
        $article = $this->model->article_edit($id);
        $files = explode(",", $article['file']);
        $this->assign("files", $files);
        $this->assign("article", $article);
        $titles = $this->model->title_add();
        $this->assign("titles", $titles);
        $this->display();
    }

    function edit()
    {
        $id = $_GET['id'];
        if ($_POST) {
            $this->model->edit($_POST, $id);
            $this->jump("index.php?control=link&action=article_edit&id=$id", "编辑成功！");
        }
    }

    function del()
    {
        if ($_POST) {
            $this->model->del($_POST);
            $this->jump("index.php?control=link&action=article");
        }
    }

    function title()
    {
        $sort = $this->model->title();
        $this->assign("sorts", $sort);
        $this->display();
    }

    function title_add()
    {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $this->assign("id", $id);
        } else {
            $this->assign("id", '');
        }
        $titles = $this->model->title_add();
        $this->assign("titles", $titles);
        $this->display();
    }

    function create()
    {
        if ($_POST) {
            $this->model->create($_POST);
            $this->jump("index.php?control=link&action=title");
        }
    }

    function sort()
    {
        if ($_POST) {
            $this->model->sort($_POST);
            $this->jump("index.php?control=link&action=title");
        }
    }

    function title_edit()
    {
        $id = $_GET['id'];
        $titles = $this->model->title_add();
        $this->assign("titles", $titles);
        $title = $this->model->title_edit($id);
        $this->assign("title", $title);
        $this->display();
    }

    function update()
    {
        if ($_POST) {
            $id = $_GET['id'];
            $this->model->update($_POST, $id);
            $this->jump("index.php?control=link&action=title_edit&id=$id");
        }
    }

    function link_del()
    {
        if ($_POST) {
            $id = $_GET['id'];
            $this->model->link_del($id);
            $this->jump("index.php?control=link&action=title");
        }
    }
}