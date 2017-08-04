<?php
namespace frontend\models;
use yii\db\ActiveRecord;

class Order extends ActiveRecord{
    public static $status=['0'=>'已取消','1'=>'待付款','2'=>'代发货','3'=>'完成'];
    public static $payments= [
        1 => ['name' => '货到付款', 'detail' => '送货上门后再收款，支持现金、POS机刷卡、支票支付'],
        2 => ['name' =>'在线支付', 'detail' => '即时到帐，支持绝大数银行借记卡及部分银行信用卡'],
        3 => ['name' =>'上门自提', 'detail' => '自提时付款，支持现金、POS刷卡、支票支付'],
        4 => ['name' => '邮局汇款', 'detail' => '通过快钱平台收款']
    ];
    public static $deliveries= [
        1 => ['name' => '普通快递送货上门', 'price' => '10.00', 'detail' => '每张订单不满499.00元,运费15.00元, 订单4...'],
        2 => ['name' => '特快专递', 'price' => '40.00', 'detail' => '每张订单不满499.00元,运费40.00元, 订单4...'],
        3 => ['name' => '加急快递送货上门', 'price' => '10.00', 'detail' => '每张订单不满499.00元,运费15.00元, 订单4...'],
        4 => ['name' => '平邮', 'price' => '10.00', 'detail' => '每张订单不满499.00元,运费15.00元, 订单4...'],
    ];
}