<?php
namespace backend\models;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

class Article extends ActiveRecord{
    public static function getStatusOptions($hidden_del=true){
        $options=[
            -1=>'删除', 0=>'隐藏', 1=>'正常'
        ];
        if($hidden_del){
            unset($options['-1']);
        }
        return $options;
    }
    public function rules(){
        return [
            [['name','intro','sort'],'required'],
            [['article_category_id','sort','status'],'integer'],
            [['name'],'string','max'=>50],
        ];
    }
    public function attributeLabels(){
        return [
            'name'=>'文章名称',
            'intro'=>'简介',
            'article_category_id'=>'文章分类',
            'sort'=>'排序',
            'status'=>'状态',
            'create_time'=>'创建时间',
        ];
    }
    public static function getArray(){
        //得到分类表的数据
        return ArrayHelper::map(ArticleCategory::find()->all(),'id','name');

    }
}