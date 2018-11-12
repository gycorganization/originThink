<?php
/**
 * Created by PhpStorm.
 * User: Dell
 * Date: 2018/11/9
 * Time: 16:29
 */

namespace app\admin\controller;


use app\admin\model\Article;

class Blog extends Common
{
    public function index()
    {
        $list=[];
        if(request()->isAjax()){
            $data=input();
            $map=[];
            if(isset($data['starttime']) && isset($data['endtime'])){
                if($data['starttime'] && $data['endtime']){
                    $map[]=['create_time', 'between time', [$data['starttime'], $data['endtime']]];
                }
            }
            empty($data['title']) || $map[]=['title','like','%'.$data['title'].'%'];
            isset($data['limit'])?$limit=$data['limit'] : $limit=10;
            $list=db('article')->where($map)->withAttr('create_time', function($value, $data) {
                return date('Y-m-d H:i:s',$value);
            })->fetchSql(false)->paginate($limit,false,['query'=>$data]);
            $data=$list->toarray();
            return (['code'=>0,'mag'=>'','data'=>$data['data'],'count'=>$data['total']]);
        }
        $this->assign('list',$list);
        return $this->fetch();
    }

    public function add()
    {
        if(request()->isPost()){
            $data=[
                'title'=>input('post.title','','trim'),
                'desc'=>input('post.desc','','trim'),
                'class_id'=>input('post.class_id',0,'intval'),
                'content'=>input('post.content'),
            ];
            $res=Article::create($data);
            if($res){
                $this->success('添加成功');
            }else{
                $this->error('添加失败');
            }
        }else{
            $class_list=db('article_class')->column('id,class_name');
            $this->assign('class_list',$class_list);
            return $this->fetch();
        }

    }
}