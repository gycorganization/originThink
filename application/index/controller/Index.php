<?php
namespace app\index\controller;

use app\index\model\ArticleClass;
use app\index\model\Comment;
use think\Controller;
use app\index\model\Article;

class Index extends Controller
{
    /**
     * 文章首页
     * @return mixed
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
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

    /**
     * 文章详情页
     * @return mixed|void
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function detail()
    {
        $article_id=$this->request->param('id',0,'intval');
        if(!$article_id) alert_error('参数错误');
        $data=Article::get($article_id);
        if(!$data){
            alert_error('文章走丢了,看看其他文章吧','javascript:history.back(-1);');
        }
        $data->views=['inc', 1];
        $data->save();
        $data=Article::get($article_id);
        $this->assign('data',$data);
        //文章分类
        $class_list= ArticleClass::column('id,class_name');
        $this->assign('class_list',$class_list);
        //相似文章
        $similarlist=Article::where('class_id','=',$data->class_id)->where('id','neq',$article_id)->limit(8)->field('id,title')->select();
        $this->assign('similarlist',$similarlist);
        //评论
        $comment=Comment::where('article_id','=',$article_id)->order('create_time desc')->select();
        $this->assign('comment',$comment);
        return $this->fetch();
    }

    /**
     * 文章列表
     * @return mixed
     * @throws \think\exception\DbException
     */
    public function article()
    {
        $keywords=$this->request->param('keywords','','trim');
        $class_id=$this->request->param('class_id',0,'intval');
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

    /**
     * 资源分享
     * @return mixed
     */
    public function resource()
    {
        return $this->fetch();
    }

    /**
     * 关于本站
     * @return mixed
     */
    public function about()
    {
        return $this->fetch();
    }

    /**
     * 点点滴滴
     * @return mixed
     */
    public function timeline()
    {
        return $this->fetch();
    }

    /**
     * 评论
     */
    public function comment()
    {
       if($this->request->isPost()){
           $article_id=$this->request->post('article_id',0,'intval');
           $content=$this->request->post('content','','trim');
           $username=$this->request->post('username','游客'.rand(11,99),'trim');
           $head=$this->request->post('head','','trim');
           $head?:$head='/images/timg.jpg';
           $data=['article_id'=>$article_id,'content'=>$content,'username'=>$username,'head'=>$head];
           $res=Comment::create($data);
           if($res){
               $data['create_time']=$res->create_time;
               Article::update(['comments'=>['inc', 1]],['id'=>$article_id]);
               $this->success('评论成功','',$data);
           }else{
               $this->error('评论失败');
           }
       }
        $this->error('非法请求');
    }

    /**
     * 点赞
     */
    public function praise()
    {
        if($this->request->isPost()){
            $article_id=$this->request->post('article_id',0,'intval');
            $res=Article::update(['praise'=>['inc', 1]],['id'=>$article_id]);
            if($res){
                $this->success('点赞成功');
            }else{
                $this->error('点赞失败');
            }
        }
        $this->error('非法请求');
    }
}
