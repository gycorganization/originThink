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
    /**
     * 文章列表
     * @return array|mixed
     * @throws \think\exception\DbException
     */
    public function index()
    {
        if ( $this->request->isAjax() ){
            $data = [
                'starttime' => $this->request->get('starttime','','trim'),
                'endtime'   => $this->request->get('endtime','','trim'),
                'key'       => $this->request->get('key','','trim'),
                'limit'     => $this->request->get('limit',10,'intval')
            ];
            $list = Article::withSearch(['name','create_time'], [
                'name'			=>	$data['key'],
                'create_time'	=>	[ $data['starttime'] , $data['endtime'] ],
            ])->paginate( $data['limit'],false , ['query' => $data] );
            return (['code' => 0,'mag' => '','data' => $list->items(),'count' => $list->total()]);
        }
        return $this->fetch();
    }


    /**
     * 添加编辑文章
     * @return mixed
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function add()
    {
        if ( $this->request->isPost() ) {
            $data=[
                'title'    => $this->request->post('title','','trim'),
                'desc'     => $this->request->post('desc','','trim'),
                'class_id' => $this->request->post('class_id',0,'intval'),
                'content'  => $this->request->post('content'),
                'img'      => $this->request->post('img'),
            ];
            $id=$this->request->post('id',0,'intval');
            if ( $id ){//编辑文章
                $res = Article::update($data,['id'=>$id]);
                if ( $res ){
                    $this->success('编辑成功');
                } else {
                    $this->error('编辑失败');
                }
            } else {//添加文章
                $res = Article::create($data);
                if ($res) {
                    $this->success('添加成功');
                } else {
                    $this->error('添加失败');
                }
            }

        } else {
            $class_list = Article::column('id,class_name');
            $this->assign('class_list',$class_list);
            $id = $this->request->get('id',0,'intval');
            if ( $id ) {
                $data = Article::where('id','=',$id)->find();
                $this->assign('data',$data);
            }
            return $this->fetch();
        }

    }

    /**
     * 删除文章
     */
    public function delete()
    {
        if ( $this->request->isPost() ){
            $id = $this->request->post('id',0,'intval');
            if ( $id ){
                $res = Article::destroy($id);
                if ( $res ){
                    $this->success('删除成功');
                } else {
                    $this->error('删除失败');
                }
            } else {
                $this->error('参数错误');
            }
        } else {
            $this->error('非法请求');
        }
    }
}