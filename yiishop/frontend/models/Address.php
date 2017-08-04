<?php

namespace frontend\models;
use Yii;
class Address extends \yii\db\ActiveRecord{
    public function rules()
    {
        return [
            [['tel', 'member_id', 'status'], 'integer'],
            [['name'], 'string', 'max' => 20],
            [['address'], 'string', 'max' => 255],
            [['province', 'city', 'area'], 'string', 'max' => 50],
        ];
    }


    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '收货人',
            'address' => '详细地址',
            'tel' => '手机号码',
            'province' => '省',
            'city' => '市',
            'area' => '区县',
            'member_id' => '用户ID',
            'status' => '状态',
        ];
    }
}
