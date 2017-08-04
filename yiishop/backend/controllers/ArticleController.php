<?php
namespace backend\controllers;
use backend\filters\RbacFilter;
use backend\models\Article;
use backend\models\ArticleContent;
use yii\data\Pagination;
use yii\web\Controller;
use yii\web\Request;

class ArticleController extends Controller{
    public function actionIndex(){//展示列表页
        //获取所有数据
        $query=Article::find()->where(['!=','status','-1']);
        $total=$query->count();
        $perPage=4;
        $pager= new Pagination([
            'totalCount'=>$total,
            'defaultPageSize'=>$perPage,
        ]);
        $model=$query->limit($pager->limit)->offset($pager->offset)->all();         //分配数据到页面
        return $this->render('index',['model'=>$model,'pager'=>$pager]);
    }
    //文章添加
    public function actionAdd(){
        $model=new Article();
        $models = new ArticleContent();
        //var_dump($models);exit;
        $request=new Request();
        if($request->isPost){
            $model->load($request->post());
            $models->load($request->post());
            if($model->validate() && $models->validate()){
                $model->create_time = time();
                $model->save();
                $models->article_id = $model->id;
                $models->save();
                \Yii::$app->session->setFlash('success','添加成功');
               return $this->redirect(['article/index']);
            }else{
                var_dump($model->getErrors());exit;
            }
        }
        return $this->render('add',['model'=>$model,'models'=>$models]);
    }
    public function actionEdit($id){
        $model=Article::findOne($id);
        $models=ArticleContent::findOne(['article_id'=>$model->id]);
        $request=new Request();
        if($request->isPost){
            $model->load($request->post());
            $models->load($request->post());
            if($model->validate() && $models->validate()){
                $model->save();
                $models->save();
                \Yii::$app->session->setFlash('success','修改成功');
                return $this->redirect(['article/index']);
            }else{
                var_dump($model->getErrors());exit;
            }
        }
        return $this->render('add',['model'=>$model,'models'=>$models]);
    }
    public function actionDelete($id){
        Article::findOne($id)->delete();
        ArticleContent::findOne(['article_id'=>$id])->delete();
       // var_dump($model);exit;
        return $this->redirect(['article/index']);
    }
    public function actionInfo($id){
        $models=ArticleContent::findOne(['article_id'=>$id]);
       //var_dump($models);exit;
        return $this->render('content',['model'=>$models]);
    }
    public function behaviors(){
        return [
            'rbac'=>[
                'class'=>RbacFilter::className(),
            ]
        ];
    }
}