<?php
namespace backend\controllers;
use backend\filters\RbacFilter;
use backend\models\Goods;
use backend\models\GoodsDayCount;
use backend\models\GoodsGallery;
use backend\models\GoodsIntro;
use flyok666\qiniu\Qiniu;
use yii\data\Pagination;
use yii\web\Controller;
use flyok666\uploadifive\UploadAction;
use yii\web\Request;

class GoodsController extends Controller{
    public function actionIndex(){
        //获取所有数据
//        $query = Goods::find()->where(['!=','status','0']);
        $request = new Request();
        $suoxu = $request->post('query');
        $query = (new \yii\db\Query())
            ->select('g.*,b.name as b_name,c.name as c_name')
            ->from('goods AS g')
            ->leftJoin('brand AS b','g.brand_id = b.id')
            ->leftJoin('goods_category AS c','g.goods_category_id = c.id')->where(['!=','g.status','0']);
        if(!empty($suoxu)){
            $query->andwhere([
                'or',
                ['like','b.name',$suoxu],
                ['like','g.name',$suoxu],
                ['like','c.name',$suoxu],
                ['like','g.sn',$suoxu],
            ]);
        };
        $perPage=5;
        $num=Goods::find()->count();
        $pager= new Pagination([
            'totalCount'=>$num,
            'defaultPageSize'=>$perPage,
        ]);
        $model=$query->limit($pager->limit)->offset($pager->offset)->all(); //分配数据到页面
        return $this->render('index',['model'=>$model,'pager'=>$pager]);
    }
    public function actionAdd(){//添加商品
        $model=new Goods();
        $introModels=new GoodsIntro();
            //加载传送数据并判断
        if($model->load(\Yii::$app->request->post())
            && $introModels->load(\Yii::$app->request->post())
            && $model->validate()
            && $introModels->validate()){
            //货号由每天日期拼接上从零到一万自增
           // $model->sn = date(Ymd,time());
            $day = date('Y-m-d');
            $goodsCount = GoodsDayCount::findOne(['day'=>$day]);
            if($goodsCount==null){
                $goodsCount = new GoodsDayCount();
                $goodsCount->day = $day;
                $goodsCount->count = 0;
                $goodsCount->save();
            }
            //字符串长度补全
            //substr('000'.($goodsCount->count+1),-4,4);
            //str_pad($goodsCount->count+1,4,'0',STR_PAD_LEFT);
            $model->sn = date('Ymd').sprintf("%04d",$goodsCount->count+1);
            $model->create_time=time();
            //var_dump( $model->sn);exit;
            //将生成的货号保存到数据库
            $model->save();
            $introModels->goods_id = $model->id;
            //将商品内容的id保存到数据库
            $introModels->save();
            $goodsCount->count++;
            $goodsCount->save();
            \Yii::$app->session->setFlash('success','添加成功');
            $this->redirect(['index']);
        }
        return $this->render('add',['model'=>$model,'introModels'=>$introModels]);
    }
    //修改商品功能
    public function actionEdit($id){
        $model=Goods::findOne($id);
        $introModels=GoodsIntro::findOne($id);
        //var_dump($model);exit;
        //加载传送数据并判断
        if($model->load(\Yii::$app->request->post())
            && $introModels->load(\Yii::$app->request->post())
            && $model->validate()
            && $introModels->validate()) {
            //保存到数据库
            $model->save();
            $introModels->save();
            \Yii::$app->session->setFlash('success', '修改成功!');
            $this->redirect(['index']);
        }
        return $this->render('add',['model'=>$model,'introModels'=>$introModels]);
    }
    //删除商品功能
    public function actionDelete($id){
        $model=Goods::findOne($id);
        $model->status=0;
        $model->save();

        return $this->redirect(['index']);
    }
    //展示商品详细内容
    public function actionInfo($id){
        $model=GoodsIntro::findOne(['goods_id'=>$id]);

        return $this->render('goods_intro',['model'=>$model]);
    }
    //添加图片功能
    public function actionAdd_photo(){
        $model= new  GoodsGallery;
        $request=new Request();
        //获取ID并保存到数据库
        $id = $request->get('id',0);
        if($request->isPost) {
            $model->load($request->post());
           /* echo "<pre>";
            var_dump($model);exit;*/
            $model->goods_id=$id;
            if ($model->validate()) {
                $model->save();
                \Yii::$app->session->setFlash('success', '添加图片成功!');
                $this->redirect(['photo','id'=>$id]);
            }
        }
        return $this->render('add_img',['model'=>$model,'id'=>$id]);
    }
    //展示图片功能
    public function actionPhoto($id){

        $photos=GoodsGallery::find()->where(['goods_id'=>$id])->all();
       // var_dump($photos);exit;
        return $this->render('photo',['model'=>$photos]);
    }
    //删除图片
    public function actionDel_img($id,$goods_id){
        //var_dump($goods_id);exit;
        GoodsGallery::findOne($id)->delete();
        \Yii::$app->session->setFlash('success', '图片删除成功!');
        return $this->redirect(['photo','id'=>$goods_id]);
    }
    public function actions()
    {
        return [
                'u-upload' => [
                    'class' => 'kucha\ueditor\UEditorAction',
                    'config' => [
                        "imageUrlPrefix"  => "",//图片访问路径前缀
                        "imagePathFormat" => "/upload/image/{yyyy}{mm}{dd}/{time}{rand:6}", //上传保存路径
                    "imageRoot" => \Yii::getAlias("@webroot"),
                    ],
                ],
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
                        'extensions' => ['jpg', 'png','gif'],
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