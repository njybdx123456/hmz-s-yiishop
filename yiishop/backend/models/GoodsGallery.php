<?php
namespace backend\models;
use yii\db\ActiveRecord;

class GoodsGallery extends ActiveRecord{
    public function rules(){
           return[
               [['goods_id','path'],'required'],
               [['path'],'string'],
               [['goods_id'],'integer']
           ];
    }
    public function attributeLabels(){
        return [
        'id'=>'ID',
          // goods_id	int
        'goods_id'=>'商品ID',
            //   path	varchar(255)
        'path'=>'图片地址'
        ];
    }
}