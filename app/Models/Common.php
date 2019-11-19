<?php
namespace App\Models;

class Common
{
    public function createTree($data,$parent_id=0){
        $temp = array();
        foreach($data as $key => $value){
            if($value['parent_id']==$parent_id){
                $value['children'] = self::createTree($data,$value['id']);
                $temp[] = $value;
            }
        }
        return $temp;
    }
}