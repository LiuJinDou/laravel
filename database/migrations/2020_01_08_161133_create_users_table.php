<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('test', function (Blueprint $table) {
            $table->bigIncrements('id');	//递增 ID（主键），相当于「UNSIGNED BIG INTEGER」
            $table->bigInteger('votes');	//相当于 BIGINT
            $table->binary('data');	//相当于 BLOB
            $table->boolean('confirmed');	//相当于 BOOLEAN
            $table->char('name', 4);	//相当于带有长度的 CHAR
            $table->date('created_at');	//相当于 DATE
            $table->dateTime('created_at');	//相当于 DATETIME
            $table->dateTimeTz('created_at');	//相当于带时区 DATETIME
            $table->decimal('amount', 8, 2);	//相当于带有精度与基数 DECIMAL
            $table->double('column', 8, 2);//	相当于带有精度与基数 DOUBLE
            $table->enum('level', ['easy', 'hard']);	//相当于 ENUM
            $table->float('amount', 8, 2);	//相当于带有精度与基数 FLOAT
            $table->geometry('positions');	//相当于 GEOMETRY
            $table->geometryCollection('positions');	//相当于 GEOMETRYCOLLECTION
            $table->increments('id');	//递增的 ID (主键)，相当于「UNSIGNED INTEGER」
            $table->integer('votes');	//相当于 INTEGER
            $table->ipAddress('visitor');	//相当于 IP 地址
            $table->json('options');	//相当于 JSON
            $table->jsonb('options');	//相当于 JSONB
            $table->lineString('positions');	//相当于 LINESTRING
            $table->longText('description');	//相当于 LONGTEXT
            $table->macAddress('device');	//相当于 MAC 地址
            $table->mediumIncrements('id');	//递增 ID (主键) ，相当于「UNSIGNED MEDIUM INTEGER」
            $table->mediumInteger('votes');	//相当于 MEDIUMINT
            $table->mediumText('description');	//相当于 MEDIUMTEXT
            $table->morphs('taggable');	//相当于加入递增的 taggable_id 与字符串 taggable_type
            $table->multiLineString('positions');	//相当于 MULTILINESTRING
            $table->multiPoint('positions');	//相当于 MULTIPOINT
            $table->multiPolygon('positions');	//相当于 MULTIPOLYGON
            $table->nullableMorphs('taggable');	//相当于可空版本的 morphs() 字段
            $table->nullableTimestamps();	//相当于可空版本的 timestamps() 字段
            $table->point('position');	//相当于 POINT
            $table->polygon('positions');	//相当于 POLYGON
            $table->rememberToken();	//相当于可空版本的 VARCHAR (100) 的 remember_token 字段
            $table->smallIncrements('id');	//递增 ID (主键) ，相当于「UNSIGNED SMALL INTEGER」
            $table->smallInteger('votes');	//相当于 SMALLINT
            $table->softDeletes();	//相当于为软删除添加一个可空的 deleted_at 字段
            $table->softDeletesTz();	//相当于为软删除添加一个可空的 带时区的 deleted_at 字段
            $table->string('name', 100);	//相当于带长度的 VARCHAR
            $table->text('description');	//相当于 TEXT
            $table->time('sunrise');	//相当于 TIME
            $table->timeTz('sunrise');	//相当于带时区的 TIME
            $table->timestamp('added_on');	//相当于 TIMESTAMP
            $table->timestampTz('added_on');	//相当于带时区的 TIMESTAMP
            $table->tinyIncrements('id');	//相当于自动递增 UNSIGNED TINYINT
            $table->tinyInteger('votes');	//相当于 TINYINT
            $table->unsignedBigInteger('votes');	//相当于 Unsigned BIGINT
            $table->unsignedDecimal('amount', 8, 2);	//相当于带有精度和基数的 UNSIGNED DECIMAL
            $table->unsignedInteger('votes');	//相当于 Unsigned INT
            $table->unsignedMediumInteger('votes');	//相当于 Unsigned MEDIUMINT
            $table->unsignedSmallInteger('votes');	//相当于 Unsigned SMALLINT
            $table->unsignedTinyInteger('votes');	//相当于 Unsigned TINYINT
            $table->uuid('id');	//相当于 UUID
            $table->year('birth_year');	//相当于 YEAR
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('test');
    }
}
