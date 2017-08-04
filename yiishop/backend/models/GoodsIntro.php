<?php
namespace backend\models;
use yii\db\ActiveRecord;

class GoodsIntro extends ActiveRecord{
    public function rules(){
        return [
            [['content'],'required'],
            [['content'],'string'],
        ];
    }
    public function attributeLabels(){
        return[
            'goods_id'=>'商品ID',
            'content'=>'内容详情',
        ];
    }
}