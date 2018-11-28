<?php
/**
 * Created by PhpStorm.
 * User: zhuangjun
 * Date: 2018/11/11
 * Time: 17:20
 */

namespace app\admin\model;
use think\Model;

class Article extends Model
{
    protected $autoWriteTimestamp = true;
    public function searchNameAttr($query, $value)
    {
        if ( $value ) {
            $query->where('user|name','like', '%' .$value . '%');
        }
    }

    public function searchCreateTimeAttr($query, $value)
    {
        if ( $value[0] && $value[1] ){
            $query->whereBetweenTime('create_time', $value[0], $value[1]);
        }
    }
}