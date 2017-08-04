<?php
/**
 * 权限控制
 */
namespace backend\controllers;

use backend\filters\RbacFilter;
use backend\models\PermissionForm;
use backend\models\RoleForm;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class RbacController extends Controller{

//    public function actionIndex(){
//        return $this->render('index');
//    }
    //权限列表
    public function actionPermissionIndex(){
        //获取权限
        $authManager=\Yii::$app->authManager;

        $models=$authManager->getPermissions();

        return $this->render('index',['model'=>$models]);
    }
    //添加权限
    public function actionAddPermission(){
        $models = new PermissionForm();
            if($models->load(\Yii::$app->request->post()) && $models->validate()){
                $authManager=\Yii::$app->authManager;
                //创建权限
                $permission=$authManager->createPermission($models->name);
                $permission->description=$models->description;
                //保存到数据表
                $authManager->add($permission);

                \Yii::$app->session->setFlash('success','权限添加成功!');
                return $this->redirect(['permission-index']);
            }
        return $this->render('add',['model'=>$models]);
    }
    //修改权限
    public function actionEditPermission($name){
        //检查权限是否存在
        $authManager=\Yii::$app->authManager;
        $permission=$authManager->getPermission($name);
        if($permission==null){
            throw new NotFoundHttpException('权限不存在!');
        }
        $models=new PermissionForm();
        if(\Yii::$app->request->isPost){
            if($models->load(\Yii::$app->request->post()) && $models->validate()){
                $permission=$authManager->createPermission($models->name);
                $permission->description=$models->description;
                //更新权限
                $authManager->update($name,$permission);
                \Yii::$app->session->setFlash('success','权限修改成功!');
                return $this->redirect(['permission-index']);
            }
        }else{
            //回显数据到表单
            $models->name=$permission->name;
            $models->description=$permission->description;
        }

        return $this->render('add',['model'=>$models]);
    }

    //删除权限
    public function actionDeletePermission($name){
        $authManager=\Yii::$app->authManager;
        $permission=$authManager->getPermission($name);

        $authManager->remove($permission);
        \Yii::$app->session->setFlash('success','删除成功!');
        return $this->redirect(['permission-index']);
    }

    //展示角色列表

    public function actionRoleIndex(){

        $authManager=\Yii::$app->authManager;
        $models=$authManager->getRoles();
        return $this->render('role-index',['model'=>$models]);
    }
    //添加角色
    public function actionAddRole(){
        $models=new RoleForm();
        if($models->load(\Yii::$app->request->post()) && $models->validate()){
            //创建和保存角色
            $authManager = \Yii::$app->authManager;
            $role = $authManager->createRole($models->name);
            $role->description=$models->description;
            $authManager->add($role);
            //给角色赋予权限
            if(is_array($models->permissions)){
                foreach($models->permissions as $permissionName){
                    $permission = $authManager->getPermission($permissionName);
                    if($permission)$authManager->addChild($role,$permission);
                }
            }
            \Yii::$app->session->setFlash('success','角色添加成功');
            return $this->redirect(['role-index']);
        }

        return $this->render('add-role',['model'=>$models]);
    }
    //修改角色和权限的关系
    public function actionEditRole($name){
        //检查权限是否存在
        $authManager=\Yii::$app->authManager;
        $permission=$authManager->getRoles($name);
        if($permission==null){
            throw new NotFoundHttpException('角色不存在!');
        }
        $model=new RoleForm();
        //var_dump( $model->permissions);exit;
            if($model->load(\Yii::$app->request->post()) && $model->validate()){
                //取消角色和权限的关联
                $authManager = \Yii::$app->authManager;
                $role = $authManager->getRole($name);
                //表单权限多选回显
                //获取角色的权限
                $permissions = $authManager->getPermissionsByRole($name);
                $model->name = $role->name;
                $model->description = $role->description;
                $model->permissions = ArrayHelper::map($permissions, 'name', 'description');
                \Yii::$app->session->setFlash('success', '角色修改成功!');
                $this->redirect(['role-index']);
            }
        return $this->render('add-role',['model'=>$model]);

    }

    //角色删除
    public function actionDeleteRole($name){
        //$model=new RoleForm();
        $authManager = \Yii::$app->authManager;
        $role = $authManager->getRole($name);
        //var_dump($role);
        \Yii::$app->session->setFlash('success','删除成功');
        return $this->redirect(['role-index']);
    }

    public function behaviors(){
        return [
            'rbac'=>[
            'class'=>RbacFilter::className(),
            ]
        ];
    }
}