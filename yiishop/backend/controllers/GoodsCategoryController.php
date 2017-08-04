<?php
namespace backend\controllers;
use backend\filters\RbacFilter;
use backend\models\GoodsCategory;
use yii\data\Pagination;
use yii\web\Controller;
use yii\web\HttpException;
use yii\web\Request;

class GoodsCategoryController extends Controller{
    //展示列表页面
    public function actionIndex(){
        //获取所有数据
        $query=GoodsCategory::find();
        $perPage=4;
        $pager= new Pagination([
            'totalCount'=>$query->count(),
            'defaultPageSize'=>$perPage,
        ]);
        $model=$query->limit($pager->limit)->offset($pager->offset)->all();         //分配数据到页面
        return $this->render('index',['model'=>$model,'pager'=>$pager]);
    }
/*    public function actionAdd(){
        $model=new GoodsCategory();
        $request=new Request();
        if($request->isPost){
            $model->load($request->post());
            if($model->validate()){
                //保存到数据库
                //$model->save();
                if($model->parent_id){
                    //非一级分类
                    $category=GoodsCategory::findOne(['id'=>$model->parent_id]);
                    if($category){
                        $model->prependTo($category);
                    }else{
                        throw new HttpException(404,'上级分类不存在');
                    }
                }else{
                    //一级分类
                    $model->makeRoot();
                }
                \Yii::$app->session->setFlash('success','添加成功!');
                $this->redirect(['index']);
            }
        }
        return $this->render('add',['models'=>$model]);
    }*/
    //添加商品分类(ztree选择上级分类)
    public function actionAdd2(){
        //
        $model=new GoodsCategory(['parent_id'=>0]);
        $request=new Request();
        if($request->isPost){
            $model->load($request->post());
            if($model->validate()){
                //判断是否是添加一级分类
                if($model->parent_id){
                    //非一级分类
                    $category=GoodsCategory::findOne(['id'=>$model->parent_id]);
                    if($category){
                        $model->prependTo($category);
                    }else{
                        throw new HttpException(404,'上级分类不存在');
                    }
                }else{
                    //一级分类
                    $model->makeRoot();
                }
                \Yii::$app->session->setFlash('success','分类添加成功!');
                $this->redirect(['index']);
            }
        }
        //获取所以分类数据
        $categories = GoodsCategory::find()->select(['id','parent_id','name'])->asArray()->all();
        return $this->render('add2',['models'=>$model,'categories'=>$categories]);
    }
    public function actionEdit($id){
        $model=GoodsCategory::findOne(['id'=>$id]);
        $request=new Request();
        if($request->isPost){
            $model->load($request->post());
            if($model->validate()){
                //保存到数据库
                if($model->parent_id){
                    //非一级分类
                    $category=GoodsCategory::findOne(['id'=>$model->parent_id]);
                    if($category){
                        $model->prependTo($category);
                    }else{
                        throw new HttpException(404,'上级分类不存在');
                    }
                }else{
                    //一级分类
                    $model->makeRoot();
                }
                \Yii::$app->session->setFlash('success','分类修改成功!');
                $this->redirect(['index']);
            }
        }
        //获取所有分类数据
        $categories = GoodsCategory::find()->select(['id','parent_id','name'])->asArray()->all();
        return $this->render('add2',['models'=>$model,'categories'=>$categories]);

    }
    public function actionDelete($id){
        $model=GoodsCategory::findOne($id);
        //查出他的id是否有parent_id与他相等,若等就不能删除,反之则可以删除
      $children=GoodsCategory::find()->where("parent_id= $id")->count();
        if($children){
            \Yii::$app->session->setFlash('danger','下面有子分类,不能删除!');

        }else{
            $model->delete();
        }
        return $this->redirect(['index']);
    }
 /*   //测试嵌套集合的用法
    public function actionTest(){
        //创建一个根节点
//        $category = new GoodsCategory();
//        $category->name='家用电器';
//        $category->makeRoot();
        //创建子节点
        $category2 = new GoodsCategory();
        $category2->name='小家电';
        $category=GoodsCategory::findOne(['id'=>1]);
        $category2->parent_id=$category->id;
        $category2->prependTo($category);

        echo '操作完成!';
    }*/
    //测试
    public function actionZtree(){
        //$this->layout=false;
        //不加载布局文件
        return $this->renderPartial('ztree');
    }
    public function behaviors(){
        return [
            'rbac'=>[
                'class'=>RbacFilter::className(),
            ]
        ];
    }
}