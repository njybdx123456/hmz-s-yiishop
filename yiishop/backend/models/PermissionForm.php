<?php
namespace backend\models;
use yii\base\Model;

class PermissionForm extends Model{
    public $name;
    public $description;
    public function rules(){
        return[
            [['name','description'],'required'],

        ];
    }
    public function attributeLabels(){
        return[
            'name'=>'名称',
            'description'=>'描述'
        ];

    }
}