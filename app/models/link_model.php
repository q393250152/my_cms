<?php

/**
 * Created by PhpStorm.
 * User: Auser
 * Date: 2015/6/20
 * Time: 21:30
 */
class LinkModel extends CommonModel
{

    public $treelist;

    function article()
    {
        $article = $this->all("select * from article");
        foreach ($article as $k => $v) {
            $cate = $this->one("select * from cate where id = '$v[cate_id]'");
            $article["$k"]["cate_name"] = $cate["name"];
        }
        return $article;

    }

    function destroy($id)
    {
        foreach ($id as $v) {
            $this->db->query("delete from article where id = '$v'");
        }

    }

    function title()
    {
        $cates = $this->all("select * from cate order by `parent_id` asc, `sort` asc, id asc ");
        foreach ($cates as $k => $v) {
            $article = $this->one("select * from article where cate_id = '$v[id]'");
            $cates["$k"]["article"] = $article["cate_id"];

        }
        $sort = $this->tree($cates);
        return $sort;
    }

    public function tree(&$data, $pid = 0, $count = 1)
    {
        foreach ($data as $key => $value) {
            if ($value['parent_id'] == $pid) {
                $value['count'] = $count;
                $this->treeList [] = $value;
                unset($data[$key]);
                $this->tree($data, $value['id'], $count + 1);
            }
        }
        return $this->treeList;
    }

    function sort($p)
    {
        $id = $p['id'];
        $sort = $p['sort'];
        foreach ($sort as $k => $v) {
            $this->db->query("update cate set `sort` = '$v' where id = '$id[$k]'");
        }
    }

    function article_add($p)
    {
        $cate_id = $p['cate_id'];
        $title = $p['title'];
        $color = $p['color'];
        $content = $p['editor1'];
        $time = strtotime($p['time']);
        $field = $p['field'];
        $paper = $p['paper'];
        $thumb = $p['thumb'];
        $file = array();
        foreach ($p['file'] as $v) {
            if ($v != ' ') {
                $file[] = $v;
            }
        }
        $file = join(",", $file);
        $this->db->query("insert into article (`cate_id`,`title`,`color`,`content`,`time`,`field`,`paper`,`thumb`,`file`)values('$cate_id','$title','$color','$content','$time','$field','$paper','$thumb','$file')");
    }

    function article_edit($id)
    {
        $article = $this->one("select * from article where id = '$id'");
        return $article;
    }

    function del($p)
    {
        $id = $p['id'];
        $this->db->query("delete from article where id = '$id'");

    }

    function edit($p, $id)
    {
        $cate_id = $p['parent'];
        $title = $p['title'];
        $color = $p['color'];
        $content = $p['editor1'];
        $time = strtotime($p['time']);
        $field = $p['field'];
        $paper = $p['paper'];
        $thumb = $p['thumb'];
        $file = implode(",", $p['file']);
        $this->db->query("update article set `cate_id`='$cate_id',`title`='$title',`color`='$color',`content`='$content',`time`='$time',
`field`='$field',`paper`='$paper',`thumb`='$thumb',`file`='$file' where id ='$id'");

    }

    function time()
    {
        $time = date("Y-m-d", time());
        return $time;
    }

    function title_add()
    {
        $cate = $this->all("select * from cate");
        $titles = $this->tree($cate);
        return $titles;
    }

    function title_edit($id)
    {
        $title = $this->one("select * from cate where id = '$id'");
        return $title;
    }

    function create($p)
    {
        $parent_id = $p['parent'];
        $name = $p['name'];
        $pinyin = $p['pinyin'];
        $type = $p['type'];
        $url = $p['url'];
        $content = $p['content'];
        $show = $p['show'];
        $this->db->query("insert into cate (`parent_id`,`name`,`pinyin`,`type`,`url`,`content`,`show`)values('$parent_id','$name','$pinyin','$type','$url','$content','$show')");

    }

    function update($p, $id)
    {
        $parent_id = $p['parent'];
        $name = $p['name'];
        $pinyin = $p['pinyin'];
        $type = $p['type'];
        $url = $p['url'];
        $content = $p['content'];
        $show = $p['show'];
        $this->db->query("update cate set `parent_id`='$parent_id',`name`='$name',`pinyin`='$pinyin',`type`='$type',`url`='$url',`content`='$content',`show`='$show' where id = '$id'");
    }

    function link_del($id)
    {
        $this->db->query("delete from cate where id = '$id' or parent_id = '$id'");
    }

}