<?php
namespace App\Models\dbs;

use Illuminate\Database\Eloquent\Model;

class privilege_group extends Model {

    /**
     * 与模型关联的数据表
     *
     * @var string
     */
    protected $table = 'privilege_group';
    /**
     * 该模型是否被自动维护时间戳
     *
     * @var bool
     */
    public $timestamps = false;
}