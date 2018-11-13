<?php
/**
 * Created by PhpStorm.
 * User: Dell
 * Date: 2018/11/13
 * Time: 16:38
 */

namespace app\admin\controller;



class Upload  extends Common
{
    public function upload(){
        $file = request()->file('file');
        $info = $file->move( '../public/uploads');
        if($info){
            $msg=['code'=>0,'msg'=>'上传成功','data'=>['src'=>'/uploads/'.$info->getSaveName()]];
        }else{
            $msg=['code'=>1,'msg'=>$file->getError()];
        }
        return $msg;
    }

}