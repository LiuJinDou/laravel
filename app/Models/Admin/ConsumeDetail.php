<?php
namespace App\Models\Admin;

use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class ConsumeDetail extends Model {

    /**
     * 与模型关联的数据表
     *
     * @var string
     */
    protected $table = 'consume_detail';
    /**
     * 该模型是否被自动维护时间戳
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * consume detail list
     * @param $limit
     * @param $page
     * @param $request
     * @return mixed
     */
    public function list($limit,$page,$request){
        $month = $request->input('month');
        $date = $request->input('date');
        $name = $request->input('name');
        $consume_id = $request->input('consume_id');
        $consumeDetail = app('ConsumeDetail');
        $consume = app('Consume');
        if (!empty($month)) {
            $consumeDetail = $consumeDetail->where('date','like','%'.$month.'%');
        }
        if (!empty($date)) {
            $consumeDetail = $consumeDetail->where('date','=',$date);
        }
        if (!empty($name)) {
            $consumeDetail = $consumeDetail->where('name','like','%'.$name.'%');
        }
        if (!empty($consume_id)) {
            $consumeDetail = $consumeDetail->where('consume_id','=',$consume_id);
            $consume = $consume->where('id','=',$consume_id);
        }
        $results = $consumeDetail->paginate($limit)->toArray();
        $consume = $consume->get(['month','id','category_id'])->toArray();
        $category_ids = array_values(array_column($consume,'category_id','category_id'));
        $category = app('consume_category')::get(['id','name'])->whereIn('id',$category_ids)->toArray();
        $consume = array_column($consume,NULL,'id');
        $category = array_column($category,'name','id');
        foreach ($consume as &$value) {
            $value['month'] = isset($category[$value['category_id']]) ? $value['month'].'--'.$category[$value['category_id']]: $value['month'];
        }
        $consume = array_column($consume,'month','id');
        $rst['data'] = $results['data'];
        foreach ($rst['data'] as &$v) {
            $v['month'] = isset($consume[$v['consume_id']]) ? $consume[$v['consume_id']] : '';
        }
        $rst['count'] = $results['total'];
        return $rst;
    }

    /**
     * consume detail save or editor
     * @param $request
     * @return mixed
     * @throws \Exception
     */
    public function detailSave($request){
        $id = $request->input('id');
        $name = $request->input('name');
        $date = $request->input('date');
        $consume_id = $request->input('consume_id');
        $amount = $request->input('amount');
        $voucher = $request->input('voucher');
        $remark = $request->input('remark');
        $label = $request->input('label');
        $amount_reg = '/^[1-9]\d*|^[1-9]\d*.\d+[1-9]$/';
        if(!preg_match($amount_reg, $amount)){
            throw  new  \Exception('Amount style error',2001);

        }
        if ($id > 0) {
            $detail =  self::find($id);
            $detail->update_at = time();
            $detail->update_uid = app('Admin')->getAdminId();
        } else {
            $detail =  app('ConsumeDetail');
            $detail->create_at = time();
            $detail->create_uid = app('Admin')->getAdminId();
        }
        $detail->name = $name;
        $detail->date = $date;
        $detail->amount = bcmul($amount,100);
        $detail->voucher = $voucher;
        $detail->consume_id = $consume_id;
        $detail->remark = $remark;
        $detail->label = $label;
        try{
            $consume =  app('Consume')::find($consume_id);
            $consume->amount = $consume->amount + $amount;
            $consume->save();
            return $detail->save();
        }catch (\Exception $exception){
            throw  new \Exception($exception->getMessage(),$exception->getCode());
        }

    }

    public function detailExport(){
        $config = [
            'path' => './tests'
        ];

        $fileObject  = new \Vtiful\Kernel\Excel($config);

        $file = $fileObject->fileName('tutorial.xlsx', 'sheet_one')
            ->header(['name', 'age'])
            ->data([
                ['viest', 23],
                ['wjx', 23],
            ]);

        $path = $file->output();
    }

}