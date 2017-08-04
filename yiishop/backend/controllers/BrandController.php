<?php
namespace backend\controllers;
use backend\filters\RbacFilter;
use backend\models\Brand;
use yii\data\Pagination;
use yii\web\Controller;
use yii\web\Request;
use yii\web\UploadedFile;
use flyok666\uploadifive\UploadAction;
use flyok666\qiniu\Qiniu;

class BrandController extends Controller{
    public function actionIndex(){
        //只显示未删除的品牌，status != -1
        $query = Brand::find()->where(['!=','status','-1']);
        //每页显示条数
        $perPage = 4;
        $pager = new Pagination([
            'totalCount'=>$query->count(),
            'defaultPageSize'=>$perPage
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
            //var_dump($request->post());exit;
            $model->imgFile = UploadedFile::getInstance($model,'imgFile');
            //var_dump($request->post());exit;
            if($model->validate()){
                if($model->imgFile){
                    $d = \Yii::getAlias('@webroot').'/upload/'.date('Ymd');
                    if(!is_dir($d)){
                        mkdir($d);
                    }
                    $fileName = '/upload/'.date('Ymd').'/'.uniqid().'.'.$model->imgFile->extension;
                    $model->imgFile->saveAs(\Yii::getAlias('@webroot').$fileName,false);

                    $model->logo = $fileName;
                }
                //保存数据到数据库
                $model->save();
                \Yii::$app->session->setFlash('success','添加成功');
                return $this->redirect(['index']);
            }else{
                var_dump($model->getErrors());exit;
            }
        }
        return $this->render('add',['model'=>$model]);
    }

    public function actionEdit($id){
        //根据id得到一行数据
        $model=Brand::findOne(['id'=>$id]);
        $request=new Request();
        if($request->isPost){
            //判断接收方式并接收数据
            $model->load($request->post());
            $model->imgFile=UploadedFile::getInstance($model,'logoPath');
            if($model->validate()){
                //验证文件上传
                if($model->imgFile){
                    $d = \Yii::getAlias('@webroot') . '/upload/' . date('Ymd');
                    if (!is_dir($d)) {
                        mkdir($d);
                    }
                    $logoName='/upload/' . date('Ymd') . '/' . uniqid() . '.' . $model->imgFile->extension;
                    $model->imgFile->saveAs(\Yii::getAlias('@webroot').$logoName,false);
                    $model->logo=$logoName;
                }
                //保存数据到数据库
                $model->save(false);
                \Yii::$app->session->setFlash('success','修改成功');
                return $this->redirect(['index']);
            }else{
                var_dump($model->getErrors());exit;
            }
        }
        //回显数据到页面
        return $this->render('add',['model'=>$model]);
    }
    //将数据放到回收站
    public function actionDelete($id){
        //查找到一条数据
        $model=Brand::findOne(['id'=>$id]);
        $model->status=-1;
        $model->save();
        return $this->redirect(['index']);
    }


    public function actions() {
        return [
            's-upload' => [
                'class' => UploadAction::className(),
                'basePath' => '@webroot/upload',
                'baseUrl' => '@web/upload',
                'enableCsrf' => true, // default
                'postFieldName' => 'Filedata', // default
                //BEGIN METHOD
               // 'format' => [$this, 'methodName'],
                //END METHOD
                //BEGIN CLOSURE BY-HASH
                'overwriteIfExist' => true,
                /*'format' => function (UploadAction $action) {
                    $fileext = $action->uploadfile->getExtension();
                    $filename = sha1_file($action->uploadfile->tempName);
                    return "{$filename}.{$fileext}";
                },*/
                //END CLOSURE BY-HASH
                //BEGIN CLOSURE BY TIME
                'format' => function (UploadAction $action) {
                    $fileext = $action->uploadfile->getExtension();
                    $filehash = sha1(uniqid() . time());
                    $p1 = substr($filehash, 0, 2);
                    $p2 = substr($filehash, 2, 2);
                    return "{$p1}/{$p2}/{$filehash}.{$fileext}";
                },
                //END CLOSURE BY TIME
                'validateOptions' => [
                    'extensions' => ['jpg', 'png'],
                    'maxSize' => 1 * 1024 * 1024, //file size
                ],
                'beforeValidate' => function (UploadAction $action) {
                    //throw new Exception('test error');
                },
                'afterValidate' => function (UploadAction $action) {},
                'beforeSave' => function (UploadAction $action) {},
                'afterSave' => function (UploadAction $action) {
                    $action->output['fileUrl'] = $action->getWebUrl();//输出文件的相对路径
//                    $action->getFilename(); // "image/yyyymmddtimerand.jpg"
//                    $action->getWebUrl(); //  "baseUrl + filename, /upload/image/yyyymmddtimerand.jpg"
//                    $action->getSavePath(); // "/var/www/htdocs/upload/image/yyyymmddtimerand.jpg"
                    //将图片上传到七牛云
                    $qiniu = new Qiniu(\Yii::$app->params['qiniu']);
                    $qiniu->uploadFile($action->getSavePath(),$action->getWebUrl());
                    $url = $qiniu->getLink($action->getWebUrl());$action->output['fileUrl']=$url;
                },
            ],
        ];
    }
    public function actionQiniu(){
        $config=[
            'accessKey'=>'fk2_cMc5333SYgwyYOaliLqhKSZlGcFhQj-Ut6MX',
            'secretKey'=>'x2MGM3-gAxbpCWqVIu3GqsNqDgKpMzVlLtbXGp9r',
            'domain'=>'http://
otdpjnkat.bkt.clouddn.com',
            'bucket'=>'yiishop',
            'area'=>Qiniu::AREA_HUADONG
        ];
            $qiniu = new Qiniu($config);
        $key='upload/78/bf/78bf79a6ea3d9afce7db521b76151b3825b0f749.jpg';
        //将文件上传到七牛云
        $qiniu->uploadFile(\Yii::getAlias(('@webroot').'/upload/78/bf/78bf79a6ea3d9afce7db521b76151b3825b0f749.jpg',$key));
        //获取该图片在七牛云的地址
        $url = $qiniu->getLink($key);
        var_dump($url);exit;
    }
    public function behaviors(){
        return [
            'rbac'=>[
                'class'=>RbacFilter::className(),
            ]
        ];
    }
}