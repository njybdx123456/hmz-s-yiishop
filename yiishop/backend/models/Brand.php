<?php
namespace backend\models;
use yii\db\ActiveRecord;

class Brand extends ActiveRecord{
    public $imgFile;//保存图片路径
   public static function getStatusOptions($hidden_del=true){
       $options=[
           -1=>'删除', 0=>'隐藏', 1=>'显示'
       ];
       if($hidden_del){
           unset($options['-1']);
       }
       return $options;
   }
    public function rules(){
        return [
            [['name','intro','sort'],'required'],
            [['intro'], 'string'],
            [['sort', 'status'], 'integer'],
            [['name'], 'string', 'max' => 50],
            [['logo'], 'string', 'max' => 255],
        ];
    }
    public function attributeLabels(){
        return [
        'id' => 'ID',
//            name	varchar(50)	名称
        'name'=>'名称',
//            intro	text	简介
        'intro'=>'简介',
//            logo	varchar(255)	LOGO图片
        'logo'=>'LOGO',
//            sort	int(11)	排序
        'sort'=>'排序',
//            status	int(2)	状态(-1删除 0隐藏 1正常)
        'status'=>'状态',
        ];
    }
}