<?php
use yii\web\JsExpression;
$form=\yii\bootstrap\ActiveForm::begin();
echo $form->field($model,'name');
//echo $form->field($model,'sn');
//无限分类
echo $form->field($model,'goods_category_id')->hiddenInput();
echo '<div>
    <ul id="treeDemo" class="ztree"></ul>
</div>';
echo $form->field($model,'brand_id')->dropDownList(\backend\models\Goods::getBrand());
//文件上传
echo $form->field($model,'logo')->hiddenInput(['id'=>'logo']);
//图片回显
echo \yii\helpers\Html::img($model->logo?$model->logo:false,['id'=>'img','height'=>50]);
echo \yii\helpers\Html::fileInput('test', NULL, ['id' => 'test']);
echo \flyok666\uploadifive\Uploadifive::widget([
    'url' => yii\helpers\Url::to(['s-upload']),
    'id' => 'test',
    'csrf' => true,
    'renderTag' => false,
    'jsOptions' => [
        'formData'=>['someKey' => 'someValue'],
        'width' => 120,
        'height' => 40,
        'onError' => new JsExpression(<<<EOF
    function(file, errorCode, errorMsg, errorString) {
    console.log('The file ' + file.name + ' could not be uploaded: ' + errorString + errorCode + errorMsg);
}
EOF
        ),
        'onUploadComplete' => new JsExpression(<<<EOF
function(file, data, response) {
    data = JSON.parse(data);
    if (data.error) {
        console.log(data.msg);
    } else {
        console.log(data.fileUrl);
        //将图片地址赋值给logo字段
        $("#logo").val(data.fileUrl);
         //将上传成功的图片回显
        $("#img").attr('src',data.fileUrl);
    }
}
EOF
        ),
    ]
]);

echo $form->field($model,'market_price');
echo $form->field($model,'shop_price');
echo $form->field($model,'stock');
echo $form->field($model,'sort');
echo $form->field($model,'is_on_sale',['inline'=>1])->radioList(\backend\models\Goods::$SaleOption);
echo $form->field($model,'status',['inline'=>1])->radioList(\backend\models\Goods::$Status);
//echo $form->field($models,'content');

echo $form->field($introModels,'content')->widget('kucha\ueditor\UEditor',[
    'clientOptions' => [
        'serverUrl'=>\yii\helpers\Url::to(['u-upload']),
        //编辑区域大小
        'initialFrameHeight' => '200',
        //设置语言
        'lang' =>'zh-cn', //中文为 zh-cn
    ]
]);
echo \yii\bootstrap\Html::submitButton('提交',['class'=>'btn btn-sm btn-success']);
\yii\bootstrap\ActiveForm::end();

//调用视图的方法加载静态资源
$this->registerCssFile('@web/zTree/css/zTreeStyle/zTreeStyle.css');
//加载js文件资源
$this->registerJsFile('@web/zTree/js/jquery.ztree.core.js',['depends'=>\yii\web\JqueryAsset::className()]);
//加载js代码
$categories = \backend\models\Goods::getGoodsCategory();
$categories[]=['id'=>0,'parent_id'=>00,'name'=>'顶级分类','open'=>1];
//var_dump($categories);exit;
$nodes=\yii\helpers\Json::encode($categories);
$this->registerJs(new \yii\web\JsExpression(
    <<<JS
var zTreeObj;
        // zTree 的参数配置，深入使用请参考 API 文档（setting 配置详解）
        var setting = {
            data: {
                simpleData: {
                    enable: true,
                    idKey: "id",
                    pIdKey: "parent_id",
                    rootPId: 0
                }
            },
            callback: {
		        onClick: function(event, treeId, treeNode){
		            //console.log(treeNode.id);
		            //将当期选中的分类的id，赋值给parent_id隐藏域

		            $("#goods-goods_category_id").val(treeNode.id);
		        }
	        }
        };
        // zTree 的数据属性，深入使用请参考 API 文档（zTreeNode 节点数据详解）


        zTreeObj = $.fn.zTree.init($("#treeDemo"), setting, {$nodes});
        zTreeObj.expandAll(true);//展开全部节点

        //获取节点
        var node = zTreeObj.getNodeByParam("id", "1", null);
        //选中节点
        zTreeObj.selectNode(node);
        //触发选中事件
JS

));