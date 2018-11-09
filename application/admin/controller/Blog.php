<?php
/**
 * Created by PhpStorm.
 * User: Dell
 * Date: 2018/11/9
 * Time: 16:29
 */

namespace app\admin\controller;


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
            empty($data['title']) || $map[]=['title','like','%'.$data['key'].'%'];
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
            $title=input('post.title');
            $des=input('post.desc');
            $type=input('post.type');
            $content=input('post.content');
            $data=[
                'title'=>$title,
                'desc'=>$des,
                'type'=>$type,
                'content'=>$content,
            ];
            $res=db('article')->insert($data);
            if($res){
                $msg=['code'=>1,'msg'=>'添加成功'];
            }else{
                $msg=['code'=>0,'msg'=>'添加失败'];
            }
            return $msg;
        }else{
            return $this->fetch();
        }

    }
}