<?php
namespace backend\controllers;
use backend\models\ArticleCategory;
use yii\data\Pagination;
use yii\web\Controller;
use yii\web\Request;

class ArticleCategoryController extends Controller{
    //展示列表页
    public function actionIndex(){
        //只显示未删除的品牌，status != -1
        $query = ArticleCategory::find()->where(['!=','status','-1']);
        $pager = new Pagination([
            'totalCount'=>$query->count(),
            'defaultPageSize'=>10,
        ]);
        $models = $query->limit($pager->limit)->offset($pager->offset)->all();
        return $this->render('index',['model'=>$models,'pager'=>$pager]);
    }
    //添加数据
    public function actionAdd(){
        $model=new ArticleCategory();
        $request=new Request();
        if($request->isPost){
           $model->load($request ->post());
            //验证数据的合法性
            if($model->validate()){
                //保存到数据库
                $model->save();
                \Yii::$app->session->setFlash('success','添加成功');
                return $this->redirect(['article-category/index']);
            }else{
                var_dump($model->getErrors());
            }
        }
        return $this->render('add',['model'=>$model]);
    }
    //修改数据
    public function actionEdit($id){
        $model=ArticleCategory::findOne($id);
        $request=new Request();
        if($request->isPost){
            $model->load($request ->post());
            //验证数据的合法性
            if($model->validate()){
                //保存到数据库
                $model->save();
                \Yii::$app->session->setFlash('danger','修改成功');
                $this->redirect(['article-category/index']);
            }else{
                var_dump($model->getErrors());
            }
        }
        return $this->render('add',['model'=>$model]);
    }
    //删除数据
    public function actionDelete($id){
        ArticleCategory::findOne($id)->delete();
        return $this->redirect(['article-category/index']);
    }
}