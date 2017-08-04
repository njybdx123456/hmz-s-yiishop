<?php
/**
 * 管理员的增删改查
 */
namespace backend\controllers;
use backend\filters\RbacFilter;
use backend\models\Admin;
use backend\models\Chan;
use backend\models\RoleForm;
use yii\captcha\CaptchaAction;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Request;
use backend\models\LoginForm;
class AdminController extends Controller{
    //管理员登陆
    public function actionLogin(){
        $model = new LoginForm();
        $request=new Request();
        if($request->isPost){
            $model->load($request->post());
            if($model->validate() && $model->login()){
               //登录成功
               \Yii::$app->session->setFlash('success','登录成功!');
               return $this->redirect(['admin/index']);
            }
        }
        return $this->render('login',['login'=>$model]);
    }
    //登录注销
    public function actionLogout(){
       \Yii::$app->user->logout();
        \Yii::$app->session->setFlash('success','注销成功!');
        return $this->redirect(['admin/login']);
    }
    //定义验证码操作
    public function actions(){
        return [
            'captcha'=>[
                'class'=>CaptchaAction::className(),
                'minLength'=>3,
                'maxLength'=>6,
            ]
        ];
    }
    //管理员登录后才可以修改数据
    public function actionAdminEdit(){
        //先判断是否登录
        if(!\Yii::$app->user->isGuest){
            //已经登录  跳转并回显到修改页面
            //获取已登录用户的信息
            if($admin=\Yii::$app->user->identity) {
                $users = new Chan();
                if ($users->load(\Yii::$app->request->post()) && $users->validate()) {
                    //将旧密码和原密码做比对
                    if (\Yii::$app->security->validatePassword($users->oldPassword, $admin->password_hash)) {
                        //将新密码和原密码做比对
                        if (!\Yii::$app->security->validatePassword($users->newPassword, $admin->password_hash)) {
                            \Yii::$app->session->setFlash('success', '修改成功!');
                            $admin->password_hash = \Yii::$app->security->generatePasswordHash($users->newPassword);
                            $admin->save();
                            return $this->redirect(['admin/index']);
                        }
                        //确认密码与新密码不符,提示错误信息
                        $this->addError('rePassword', '确认密码与新密码不符!');
                    }
                    $this->addError('old_Password', '旧密码输入错误!');
                }
            }
//            //将密码 邮箱和用户名赋值给$password,$users->email,$users->username
//            $users->username=$user->username;
//            $users->email=$user->email;
//
//            $password = $users->password_hash;
//            $request= new Request();
//            if($request->isPost){
//                //获取修改后的数据
//                $users->load($request->post());
//                if($users->password_hash == $password){
//                    if($users->newPassword == $users->rePassword){
//                        if($user->validate()){
//                            //修改成功
//                            \Yii::$app->session->setFlash('success','修改成功!');
//                            $user->save();
//                            return $this->redirect(['admin/index']);
//                        }
//                    }else{
//                        //确认密码与新密码不符,提示错误信息
//                        $this->addError('rePassword','确认密码与新密码不符!');
//                        return false;
//                    }
//                }else{
//                    //旧密码输入错误,提示错误信息
//                    $this->addError('old_Password','旧密码输入错误!');
//                    return false;
//                }
//            }
           return $this->render('edit',['model'=>$users]);
        }else{
            //未登录,跳转到登录框
           return $this->redirect(['login']);
        }
    }
    //展示管理员列表
    public function actionIndex(){
        //从数据库得到所有数据
        $admins=Admin::find()->all();
        //分配数据到列表页面
        return $this->render('index',['model'=>$admins]);
    }
    //添加管理员
    public function actionAdd(){
        $admin=new Admin();
        //$roles=new RoleForm();
        if($admin->load(\Yii::$app->request->post()) && $admin->validate()){
            $admin->status= 1;
            $admin->created_at=time();
            //将密码加密保存
            $admin->password_hash=\Yii::$app->security->generatePasswordHash($admin->password_hash);
            $admin->save();
            $authManager=\Yii::$app->authManager;
            //$authManager->revokeAll($this->id);

            if(is_array($admin->roles)){
                foreach($admin->roles as $roleName){
                    $role = $authManager->getRole($roleName);
                    //var_dump($role);exit;
                    if($role)$authManager->assign($role,$admin->id);

                }
            }
        \Yii::$app->session->setFlash('success',['管理员添加成功!']);
                $this->redirect(['index']);
        }
        //加载添加页面
       return $this->render('add',['adminModel'=>$admin]);
    }
    //修改管理员
    public function actionEdit($id){
        $model=Admin::findOne($id);
        if($model == null){
            throw new NotFoundHttpException('用户不存在');
        }
        $model->roles=ArrayHelper::map(\Yii::$app->authManager->getRolesByUser($id),'name','description');
        if($model->load(\Yii::$app->request->post()) && $model->validate()){
            //将密码加密保存
            $model->password_hash=\Yii::$app->security->generatePasswordHash($model->password_hash);
            $model->save();

            $authManager=\Yii::$app->authManager;
            $authManager->revokeAll($this->id);

            if(is_array($this->roles)){
                foreach($this->roles as $roleName){
                    $role = $authManager->getRole($roleName);
                    if($role)$authManager->assign($role,$id);
                }
            }
            \Yii::$app->session->setFlash('success',['管理员修改成功!']);
            $this->redirect(['index']);
        }
        //加载添加页面
       return $this->render('add',['adminModel'=>$model]);
    }
    //删除管理员
    public function actionDelete($id){
        $model=Admin::findOne($id);
        $model->delete();
//        $model->status = 0;
//        $model->save();
        //var_dump($model);exit;
        return $this->redirect(['index']);

    }

    public function behaviors(){
        return [
            'rbac'=>[
                'class'=>RbacFilter::className(),
            ]
        ];
    }
}