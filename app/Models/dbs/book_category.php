<?php
namespace App\Models\dbs;

use Illuminate\Database\Eloquent\Model;

class book_category extends Model {

    /**
     * 与模型关联的数据表
     *
     * @var string
     */
    protected $table = 'book_category';
    /**
     * 该模型是否被自动维护时间戳
     *
     * @var bool
     */
    public $timestamps = false;
}