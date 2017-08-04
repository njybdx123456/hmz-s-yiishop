<?php
namespace backend\models;
use yii\base\Model;

class RoleForm extends Model{
    public $name;
    public $description;
    public $permissions=[];
    public function rules(){
        return[
            [['name','description'],'required'],
            ['permissions','safe'],
        ];
    }
    public function attributeLabels(){
        return[
            'name'=>'名称',
            'description'=>'描述',
            'permissions'=>'许可'
        ];
    }
}