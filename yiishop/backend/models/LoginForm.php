<?php
namespace backend\models;
use yii\base\Model;

class LoginForm extends Model{
    public $code;//验证码
    public $password;
    public $username;
    public $rememberMe;//自动登录
    public function rules(){
        return [
            [['username','password'],'required'],
            [['username'],'string','max'=>50],
            ['password','string','min'=>6],
            //验证码
            ['code','captcha','captchaAction'=>'admin/captcha'],
            ['rememberMe', 'boolean'],
        ];
    }
    public function attributeLabels(){
        return[
            'code'=>'验证码',
            'password'=>'密码',
            'username'=>'管理员名称',
        ];
    }
    public function login(){
        //通过用户名查找用户
        $user=Admin::findOne(['username'=>$this->username]);
        //  var_dump($user);exit;
        if($user){
            //验证密码
            if(\Yii::$app->security->validatePassword($this->password,$user->password_hash)){
                //密码正确,可以登录
                \Yii::$app->user->login($user,$this->rememberMe ? 3600*24*30:0);
                $user->last_login_time=time();
                $user->last_login_ip=ip2long(\Yii::$app->request->userIP);
                $user->save();
                return true;
            }else{
                //密码错误,提示错误信息
                $this->addError('password','密码输入错误!');
                return false;
            }
        }else{
            //用户不存在
            $this->addError('username','用户名不存在!');
        }
        return false;
    }

}