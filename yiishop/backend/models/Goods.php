<?php
namespace backend\models;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

class Goods extends ActiveRecord{
    public static $Status=[1=>'显示',0=>'隐藏'];//状态值
    public static $SaleOption=[1=>'在售',0=>'下架'];//是否上架
    //得到商品分类表的数据
    public static function getGoodsCategory(){
        return GoodsCategory::find()->select(['id','parent_id','name'])->asArray()->all();
    }
     //得到品牌表的数据
    public static function getBrand(){

        return ArrayHelper::map(Brand::find()->all(),'id','name');
    }
    public function rules(){
        return [
            [[ 'name','sort','stock','shop_price','market_price','logo'],'required'],
            [['goods_category_id','brand_id','is_on_sale','status',],'integer'],
            [['name'],'string','max'=>50],
        ];
    }
    public function attributeLabels(){
        return [
            'name'=>'商品名称',
//            name	varchar(20)	商品名称
            'sn'=>'货号',
//            sn	varchar(20)	货号
            'logo'=>'LOGO图片',
//            logo	varchar(255)	LOGO图片
            'goods_category_id'=>'商品分类',
//            goods_category_id	int	商品分类id
            'brand_id'=>'品牌分类',
//            brand_id	int	品牌分类
            'market_price'=>'市场价格',
//            market_price	decimal(10,2)	市场价格
            'shop_price'=>'商品价格',
//            shop_price	decimal(10, 2)	商品价格
            'stock'=>'库存',
//            stock	int	库存
            'is_on_sale'=>'是否在售',
//            is_on_sale	int(1)	是否在售(1在售 0下架)
            'status'=>'状态',
//            status	inter(1)	状态(1正常 0回收站)
            'sort'=>'排序',
//            sort	int()	排序
            'create_time'=>'添加时间',
//            create_time	int()	添加时间
            'view_times'=>'浏览次数',
//            view_times	int()	浏览次数
        ];
    }

}