<?php

namespace frontend\models;

use Yii;

class Cart extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return 'cart';
    }


    public function rules()
    {
        return [
            [['goods_id', 'amount', 'member_id'], 'integer'],
        ];
    }


    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'goods_id' => '商品id',
            'amount' => '商品数量',
            'member_id' => '	用户id',
        ];
    }
}
