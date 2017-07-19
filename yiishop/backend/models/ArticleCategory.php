<?php
namespace backend\models;
use yii\db\ActiveRecord;

class ArticleCategory extends ActiveRecord{
    public function rules(){
        return[
            [['intro'], 'string'],
            [['sort', 'status'], 'integer'],
            [['name'], 'string', 'max' => 50],
        ];
    }
    public function attributeLabels(){
        return [
        'id' => 'ID',
//            name	varchar(50)	名称
        'name'=>'名称',
//            intro	text	简介
        'intro'=>'简介',

//            sort	int(11)	排序
        'sort'=>'排序',
//            status	int(2)	状态(-1删除 0隐藏 1正常)
        'status'=>'状态',
        ];
    }
}