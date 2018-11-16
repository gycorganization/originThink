<?php
namespace app\index\controller;

use app\index\model\Comment;
use think\Controller;
use app\index\model\Article;
class Index extends Controller
{
    public function index()
    {
        //文章列表
        $list=Article::order('id desc')->limit(10)->select();
        $this->assign('list',$list);
        //热文
        $hotlist=Article::order('views desc')->limit(8)->field('id,title')->select();
        $this->assign('hotlist',$hotlist);
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
        //文章分类
        $class_list=db('article_class')->column('id,class_name');
        $this->assign('class_list',$class_list);
        //相似文章
        $similarlist=Article::where('class_id','=',$data->class_id)->where('id','neq',$article_id)->limit(8)->field('id,title')->select();
        $this->assign('similarlist',$similarlist);
        //评论
        $comment=Comment::where('article_id','=',$article_id)->select();
        $this->assign('comment',$comment);
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

    public function resource()
    {
        return $this->fetch();
    }

    public function comment()
    {
       if($this->request->isPost()){
           $article_id=$this->request->post('article_id',0,'intval');
           $content=$this->request->post('content','','trim');
           $username=$this->request->post('username','游客'.rand(11,99),'trim');
           $head=$this->request->post('head','/images/timg.jpg','trim');
           $head?:$head='/images/timg.jpg';t;
           $data=['article_id'=>$article_id,'content'=>$content,'username'=>$username,'head'=>$head];
           $res=Comment::create($data);
           if($res){
               $data['create_time']=$res->create_time;
               $this->success('评论成功','',$data);
           }else{
               $this->error('评论失败');
           }
       }
        $this->error('非法请求');
        
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
