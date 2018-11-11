<?php
namespace app\index\controller;

use think\Controller;
use app\index\model\Article;
class Index extends Controller
{
    public function index()
    {
        $list=Article::order('id desc')->limit(10)->select();
        $this->assign('list',$list);
        return $this->fetch();
    }

    public function detail()
    {
        $article_id=input('id',0,'intval');
        if(!$article_id) return $this->error('参数错误');
        $data=Article::get($article_id);
        $data->views=['inc', 1];
        $data->save();
        $data=Article::get($article_id);
        $this->assign('data',$data);
        $class_list=db('article_class')->column('id,class_name');
        $this->assign('class_list',$class_list);
        return $this->fetch();
    }

    public function article()
    {
        $keywords=input('keywords','','trim');
        $class_id=input('class_id',0,'intval');
        $where=[];
        empty($keywords) || $where[]=['title','like','%'.$keywords.'%'];
        empty($class_id) || $where[]=['class_id','=',$class_id];
        $list=Article::where($where)->order('id desc')->paginate(10,false,['query'=>input()]);
        $count=$list->total();
        $this->assign('count',$count);
        $this->assign('list',$list);
        $class_list=db('article_class')->column('id,class_name');
        $this->assign('class_list',$class_list);
        return $this->fetch();
    }
    public function index2()
    {
        Task::async(function ($serv, $task_id, $data) {
            $i = 0;
            while ($i < 10) {
                $i++;
                echo $i;
                sleep(1);
            }
        });
        $timeid=Timer::tick(1000,function(){
            var_dump(1);
        });
        return $timeid;
    }

    public function test($timeid)
    {
        Timer::clear($timeid);
    }
}
