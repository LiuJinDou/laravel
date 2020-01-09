<?php
namespace App\Models\Admin;

use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class Consume extends Model {

    /**
     * 与模型关联的数据表
     *
     * @var string
     */
    protected $table = 'consume';
    /**
     * 该模型是否被自动维护时间戳
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * list
     * @param $limit
     * @param $page
     * @param $request
     * @return mixed
     */
    public function list($limit,$page,$request){
        $category_id = $request->input('category_id');
        $year = $request->input('year');
        $month = $request->input('month');
        $consume = app('Consume');
        if (!empty($category_id)) {
            $consume = $consume->where('category_id','=',$category_id);
        }
        if (!empty($month)) {
            $consume = $consume->where('month','=',$month);
        }
        if (!empty($year)) {
            $consume = $consume->where('month','like','%'.$year.'%');
        }
        if ($month == 0 && $month !=null) {
            $consume = $consume->where('month','=',date('Y-m'));
        }
        $rtn = $consume->paginate($limit);
        $results = $rtn->toArray();
        $category = app('consume_category')::all(['name','id'])->toArray();
        $category = array_column($category,'name','id');
        $rst['data'] = $results['data'];
        foreach ($rst['data'] as &$v) {
            $v['category_name'] = isset($category[$v['category_id']]) ? $category[$v['category_id']] : '';
        }
        $rst['count'] = $results['total'];
        $rst['last_page_url'] = $results['last_page_url'];
        $rst['next_page_url'] = $results['next_page_url'];
        $rst['prev_page_url'] = $results['prev_page_url'];
        $rst['first_page_url'] = $results['first_page_url'];
        return $rst;
    }

    /**
     * add/editor one
     * @param $request
     * @return mixed
     */
    public function consumeSave($request){
        $id = $request->input('id');
        $month = $request->input('month');
        $category_id = $request->input('category_id');
        $amount = $request->input('amount');
        $remark = $request->input('remark');
        $label = $request->input('label');
        if ($id > 0) {
            $consume =  self::find($id);
            $consume->update_at = time();
            $consume->update_uid = app('Admin')->getAdminId();
        } else {
            $consume =  app('Consume');
            $consume->create_at = time();
            $consume->create_uid = app('Admin')->getAdminId();
        }
        $consume->month = $month;
        $consume->amount = $amount;
        $consume->category_id = $category_id;
        $consume->remark = $remark;
        $consume->label = $label;
        return $consume->save();
    }

    /**
     * batch add
     * @param $request
     * @return mixed
     * @throws \Exception
     */
    public function batchAdd($request){
        $month = $request->input('month');
        $category = $request->input('category');

        if (empty($month) || empty($category)) {
            throw  new \Exception('参数有误',2001);
        }
        try{
            $data = [];
            foreach ($category as $value){
                $v['category_id'] = $value['id'];
                $v['create_at'] = time();
                $v['month'] = $month;
                $data[] = $v;
            }
            $id =app('Consume')::insert($data);
        }catch (\Exception $exception){
            throw  new \Exception($exception->getMessage(),$exception->getCode());
        }
        return $id;
    }

    /**
     * consume Echars
     * @param $request
     * @return mixed
     */
    public function echars($request){
        $month = $request->input('month',date('Y-m'));
        $exists_month = app('Consume')->where('month','=',$month)->exists();
        $exists_day = app('ConsumeDetail')->where('date','like',"%$month%")->exists();
        $rst['consume_month'] = [];
        $rst['consume_day'] = [];
        if ($exists_month) {
            $results = app('Consume')->where('month','=',$month)->get(['category_id','month','id','real_amount'])->toArray();
            $resultsYear = app('Consume')->where('month','like','%'.substr($month,0,4).'%')
                ->groupBy('month')
                ->get(['id',DB::raw('SUM(real_amount) as real_amount'),'month'])
                ->toArray();
            $category = $this->category();
            $category = array_column($category,'name','id');
            foreach ($results as $k=> &$v) {
                if ($v['real_amount'] == 0) {
                    unset($results[$k]);continue;
                } else {
                    $v['real_amount'] = bcdiv($v['real_amount'],100);
                }
                $v['category_name'] = isset($category[$v['category_id']]) ? $category[$v['category_id']] : '';
                $v['month'] = substr($v['month'],5,2);
            }
            foreach ($resultsYear as $key=> &$value) {
                if ($value['real_amount'] == 0) {
                    unset($results[$key]);continue;
                } else {
                    $value['real_amount'] = bcdiv($value['real_amount'],100);
                }
                $value['month'] = substr($value['month'],5,2);
            }
            $rst['consume_year'] = $resultsYear;
            $rst['consume_month'] = $results;
        }
        if ($exists_day) {
            $results = app('ConsumeDetail')->where('date','like','%'.$month.'%')
                                        ->groupBy('date')
                                        ->get(['id',DB::raw('SUM(amount) as amount'),'date'])
                                        ->toArray();
            $rst['consume_day'] = array_map(function($item){
                $item['amount'] = bcdiv($item['amount'],100,2);
                $item['date'] = substr($item['date'],8);
                return  $item;
            },$results);
        }
        return $rst;
    }

    /**
     * category list
     * @return mixed
     */
    public function category(){
        $category = app('consume_category')::all(['name','id'])->toArray();
        return $category;
    }

    /**
     * consume a info
     * @param $id
     * @return mixed
     */
    public function info($id){
        $rtn = app('Article')->where('id','=',$id)->first();
        return $rtn;
    }

    /**
     * category list
     * @return mixed
     */
    public function categoryList(){
        return app('Category')::all()->toArray();
    }
    /**
     * add/editor one
     * @param $request
     * @return mixed
     */
    public function categorySave($request){
        $id = $request->input('id');
        $name = $request->input('name');
        if ($id > 0) {
            $consume =  app('consume_category')->find($id);
        } else {
            $consume =  app('consume_category');
        }
        $consume->name = $name;
        return $consume->save();
    }
}