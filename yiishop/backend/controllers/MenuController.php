<?php
/**
 * 菜单
 */
namespace backend\controllers;
use backend\filters\RbacFilter;
use backend\models\Menu;
use yii\data\Pagination;
use yii\web\Controller;

class MenuController extends Controller{

    public function actionIndex(){
        //获取所有的数据
        $menus=Menu::find();
        //$menus = Menu::find()->where(['parent_id'=>0])->all();
        $perPage=6;
        $num=Menu::find()->count();
        $pager= new Pagination([
            'totalCount'=>$num,
            'defaultPageSize'=>$perPage,
        ]);
        $model=$menus->limit($pager->limit)->offset($pager->offset)->all(); //分配数据到页面
        //跳转到列表页面并赋值
        return $this->render('index',['menus'=>$model,'pager'=>$pager]);
    }

    public function actionAdd(){
        $menus=new Menu();
            if($menus->load(\Yii::$app->request->post()) && $menus->validate()){
                $menus->save();

                \Yii::$app->session->setFlash('success', '菜单添加成功!');
                return $this->redirect(['index']);
            }
        return $this->render('add',['menu'=>$menus]);
    }

    public function actionEdit($id){
        $menus=Menu::findOne($id);
            if($menus->load(\Yii::$app->request->post()) && $menus->validate()){
                $menus->save();
                \Yii::$app->session->setFlash('success','菜单添加成功!');
                return $this->redirect(['index']);
            }
        return $this->render('add',['menu'=>$menus]);
    }
    public function actionDelete($id){
        $menu=Menu::findOne($id);
        $menu->delete();
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