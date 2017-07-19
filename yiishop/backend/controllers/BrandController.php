<?php
/**
 * 品牌表的增删改查
 */
namespace backend\controllers;
use backend\models\Brand;
use yii\data\Pagination;
use yii\web\Controller;
use yii\web\Request;
use yii\web\UploadedFile;

class BrandController extends Controller{
    public function actionIndex(){
        //只显示未删除的品牌，status != -1
        $query = Brand::find()->where(['!=','status','-1']);
        $pager = new Pagination([
            'totalCount'=>$query->count(),
            'defaultPageSize'=>10,
        ]);



        $models = $query->limit($pager->limit)->offset($pager->offset)->all();
        return $this->render('index',['model'=>$models,'pager'=>$pager]);
    }

    public function actionAdd(){
        $model=new Brand();
        $request=new Request();
        if($request->isPost){
            //判断接收方式并接收数据
            $model->load($request->post());
//            $model->logoPath=UploadedFile::getInstance($model,'logoPath');
            $model->logoPath=UploadedFile::getInstance($model,'logoPath');
            //var_dump($model->logoPath);exit;
            if($model->validate()){
                //验证文件上传
                if($model->logoPath){
                    $d = \Yii::getAlias('@webroot') . '/upload/' . date('Ymd');
                    if (!is_dir($d)) {
                        mkdir($d);
                    }
                    $logoName='/upload/' . date('Ymd') . '/' . uniqid() . '.' . $model->logoPath->extension;
                   $model->logoPath->saveAs(\Yii::getAlias('@webroot').$logoName,false);
                    $model->logo=$logoName;
                }
                //保存数据到数据库
                $model->save();
                \Yii::$app->session->setFlash('success','添加成功');
                return $this->redirect(['brand/index']);
            }else{
                var_dump($model->getErrors());exit;
            }
        }
        return $this->render('add',['model'=>$model]);
    }
    public function actionEdit($id){
        //根据id得到一行数据
        $model=Brand::findOne($id);
        $request=new Request();
        if($request->isPost){
            //判断接收方式并接收数据
            $model->load($request->post());
            $model->logoPath=UploadedFile::getInstance($model,'logoPath');
            if($model->validate()){
                //验证文件上传
                if($model->logoPath){
                    $d = \Yii::getAlias('@webroot') . '/upload/' . date('Ymd');
                    if (!is_dir($d)) {
                        mkdir($d);
                    }
                    $logoName='/upload/' . date('Ymd') . '/' . uniqid() . '.' . $model->logoPath->extension;
                    $model->logoPath->saveAs(\Yii::getAlias('@webroot').$logoName,false);
                    $model->logo=$logoName;
                }
                //保存数据到数据库
                $model->save(false);
                \Yii::$app->session->setFlash('success','修改成功');
                return $this->redirect(['brand/index']);
            }else{
                var_dump($model->getErrors());exit;
            }
        }
        //回显数据到页面
        return $this->render('add',['model'=>$model]);
    }
    public function actionDelete($id){
        //删除数据
        Brand::findOne($id)->delete();
        //跳转到列表
        $this->redirect(['brand/index']);
    }

}