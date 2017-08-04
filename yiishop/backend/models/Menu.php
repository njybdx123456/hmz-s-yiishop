<?php
namespace backend\models;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

class Menu extends ActiveRecord{
    //菜单的增删改查 菜单和权限的关联
    public function rules(){
        return[
            [['name','parent_id'],'required'],
            ['parent_id','integer'],
            ['route','string']
        ];
    }
    public function attributeLabels(){
        return[
            'name'=>'名称',
            'route'=>'路由',
            'parent_id'=>'上级菜单',
        ];
    }
    //获取路由
    public static function getPermissionOption(){
       return ArrayHelper::map(\Yii::$app->authManager->getPermissions(),'name','description');
    }
    //获取上级菜单选项
    public static function getMenuOption(){
        return ArrayHelper::merge([0=>'顶级菜单'],ArrayHelper::map(self::find()->where(['parent_id'=>0])->asArray()->all(),'id','name'));
    }
    //获取子菜单
    public function getChildren()
    {
        return $this->hasMany(self::className(),['parent_id'=>'id']);
    }
}