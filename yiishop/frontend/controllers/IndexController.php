<?php
namespace frontend\controllers;
use frontend\models\Goods;
use frontend\models\GoodsCategory;
use yii\db\Query;
use yii\web\Controller;
use yii\web\Cookie;

class IndexController extends Controller{
    public $layout=false;
    //网站首页
    public function actionIndex(){
        //商品分类数据
        $goods =GoodsCategory::find()->where(['parent_id'=>0])->all();
        //商品搜索
        $query = (new Query())
            ->select('g.*,b.name as b_name,c.name as c_name')
            ->from('goods AS g')
            ->leftJoin('brand AS b','g.brand_id = b.id')
            ->leftJoin('goods_category AS c','g.goods_category_id = c.id')->where(['!=','g.status','0']);
        if(!empty($name)){
            $query->andwhere([
                'or',
                ['like','b.name',$name],
                ['like','g.name',$name],
                ['like','c.name',$name],
                ['like','g.sn',$name],
            ]);
        };
      return $this->render('index',['goods'=>$goods,'data'=>$query]);
    }
    //支付
    public function actionPay(){

        return $this->render('pay-all');
    }
    //付款成功,跳转到成功页面
    public function actionSuccess(){

        return $this->render('success');
    }
    //购物车页面
    public function actionCart(){
        //每位用户购物车里面的商品都不一样
        //根据用户id查出用户的商品
        //$models=;
        return $this->render('mycart');
    }

    //添加到购物车成功页面
    public function actionAddToCart($goods_id,$amount){
        //根据商品id查出商品所有信息
        $goods=Goods::findOne(['id'=>$goods_id]);
        //如果没有登录就存放在cookie中
        $cookies=\Yii::$app->request->cookies;
        //获取cookie中购物车的数据
        $cart=$cookies->get('cart');
        if($cart == null){
            $cart=[$goods_id=>$amount];
        }

        //将商品id和数量写入cookie中
        $cookies=\Yii::$app->response->cookies;
        $cookie=new Cookie([
            'name'=>'cart',
            'value'=>serialize($cart),
            //保存时间为一周
            'expire'=>24*3600*7,
        ]);
        $cookies->add($cookie);

        return $this->render('mycart',['goods'=>$goods,'num'=>$amount]);
    }
}