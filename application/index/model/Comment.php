<?php
/**
 * Created by PhpStorm.
 * User: Dell
 * Date: 2018/11/16
 * Time: 17:19
 */

namespace app\index\model;

use think\Model;
class Comment extends Model
{
    protected $autoWriteTimestamp = true;
    protected $updateTime = false;
}