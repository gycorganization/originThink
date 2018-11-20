<?php
/**
 * Created by PhpStorm.
 * User: zhuangjun
 * Date: 2018/11/11
 * Time: 16:44
 */
namespace app\index\model;
use think\Model;
class Article extends Model
{
    protected $autoWriteTimestamp = true;

    public function getClass()
    {
        return $this->hasOne('ArticleClass','id','class_id');
    }
}