<?php
namespace backend\models;
use yii\db\ActiveRecord;

class Chan extends ActiveRecord{
    public $oldPassword;//旧密码
    public $newPassword;//新密码
    public $rePassword;//确认密码
    public function rules(){
        return[
            [['oldPassword','newPassword','rePassword'],'required'],
            ['newPassword','string','min'=>6],
        ];
    }
    public function attributeLabels(){
        return [
            'oldPassword'=>'旧密码',
            'newPassword'=>'新密码',
            'rePassword'=>'确认密码'
        ];
    }
}