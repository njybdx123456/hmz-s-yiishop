<?php
namespace backend\filters;

use yii\base\ActionFilter;
use yii\web\ForbiddenHttpException;

class RbacFilter extends ActionFilter{
    public function beforeAction($action){
        //如果用户没有登录,引导用户登录
//        if(\Yii::$app->user->isGuest){
//            return $action->controller->redirect(\Yii::$app->user->loginUrl);
//        }
        //唯一路由
//        if(!\Yii::$app->user->can($action->uniqueId)){
//            //return false;
//            throw new ForbiddenHttpException('对不起,您没有该执行权限!');
//        }
        //通行
        return parent::beforeAction($action);
    }
}