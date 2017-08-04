<?php
namespace frontend\controllers;
use frontend\models\Goods;
use frontend\models\GoodsCategory;
use yii\web\Controller;

class GoodsController extends Controller{

    public $layout = false;
    public $enableCsrfValidation=false;
    //商品列表
    public function actionIndex(){
        $models = Goods::find()->limit(8)->all();
        //全部商品分类
        $goods=$goodsCategories=GoodsCategory::find()->where(['parent_id'=>0])->all();
        return $this->render('list',['models'=>$models,'goods'=>$goods]);
    }
    //商品详情
    public function actionContent($id){

        $model=Goods::findOne(['id'=>$id]);
        //全部商品分类
        $goods=$goodsCategories=GoodsCategory::find()->where(['parent_id'=>0])->all();
        return $this->render('content',['model'=>$model,'goods'=>$goods]);
    }


}