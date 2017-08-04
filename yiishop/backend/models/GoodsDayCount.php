<?php
namespace backend\models;
use yii\db\ActiveRecord;

class GoodsDayCount extends ActiveRecord{
    public function rules(){
       return [
//           day	date	日期
            [['day','count'],'required'],
           [['count'],'integer'],
//            count	int	商品数
       ];
    }
    public function attributeLabels(){
        return [
//        day	date
        'day'=>'日期',
//        count	int
        'count'=>'商品数'
        ];
    }
}