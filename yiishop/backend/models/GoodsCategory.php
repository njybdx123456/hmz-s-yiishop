<?php
/**
 * 商品分类的增删改查
 */
namespace backend\models;
use yii\db\ActiveRecord;
use creocoder\nestedsets\NestedSetsBehavior;
class GoodsCategory extends ActiveRecord{
    public function rules(){
        return [
            [['name','parent_id','intro'],'required'],
            [['parent_id','depth','tree','lft','rgt'],'integer'],
            [['name'],'string','max'=>50],
        ];
    }
    public function attributeLabels(){
        return [
            'tree' =>'树id',
            'lft' =>'左值',
            'rgt' =>'右值',
            'depth' =>'层级',
            'name' =>'名称',
            'parent_id' =>'上级分类',
            'intro' =>'简介',
        ];
    }
    //嵌套集合行为
    public function behaviors() {
        return [
            'tree' => [
                'class' => NestedSetsBehavior::className(),
                 'treeAttribute' => 'tree',
                 'leftAttribute' => 'lft',
                 'rightAttribute' => 'rgt',
                 'depthAttribute' => 'depth',
            ],
        ];
    }

    public function transactions()
    {
        return [
            self::SCENARIO_DEFAULT => self::OP_ALL,
        ];
    }
    public static function find()
    {
        return new GoodsCategoryQuery(get_called_class());
    }
}