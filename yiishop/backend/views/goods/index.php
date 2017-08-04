<?=\yii\bootstrap\Html::a('添加',['goods/add'],['class'=>'btn btn-sm btn-info'])?>
<form action="" method="get">
    <input type="text" name="query" placeholder="请输入商品名称，货号，品牌，分类" />
<input type="submit" value="搜索" />
</form>
<?php
///*
// *  @var $this yii web/view
// */
//$form = \yii\bootstrap\ActiveForm::begin([
//    'method' => 'get',
//    //get方式提交,需要显式指定action
//    'action'=>\yii\helpers\Url::to(['goods/index']),
//    'layout'=>'inline'
//]);
//echo $form->field($model,'name')->textInput(['placeholder'=>'商品名'])->label(false);
//echo $form->field($model,'sn')->textInput(['placeholder'=>'货号'])->label(false);
//echo $form->field($model,'minPrice')->textInput(['placeholder'=>'￥'])->label(false);
//echo $form->field($model,'maxPrice')->textInput(['placeholder'=>'￥'])->label('-');
//echo \yii\bootstrap\Html::submitButton('<span class="glyphicon glyphicon-search"></span>搜索',['class'=>'btn btn-default']);
//\yii\bootstrap\ActiveForm::end();
//?>
<table class="table table-bordered table-striped">
    <tr>
        <th>ID</th>
        <th>商品名称</th>
        <th>货号</th>
        <th>商品分类</th>
        <th>商品品牌</th>
        <th>LOGO图片</th>
        <th>市场价格</th>
        <th>商品价格</th>
        <th>库存</th>
        <th>是否在售</th>
        <th>状态</th>
        <th>排序</th>
        <th>添加时间</th>
        <th>浏览次数</th>
        <th>操作</th>
    </tr>
    <?php foreach($model as $good):?>
    <tr>
        <td><?=$good['id']?></td>
        <td><?=$good['name']?></td>
        <td><?=$good['sn']?></td>
        <td><?=$good['c_name']?></td>
        <td><?=$good['b_name']?></td>
        <td><?=\yii\bootstrap\Html::img($good['logo'],['height'=>60])?></td>
        <td><?=$good['market_price']?></td>
        <td><?=$good['shop_price']?></td>
        <td><?=$good['stock']?></td>
        <td><?=$good['is_on_sale'] == 1 ? '在售':'下架';?></td>
        <td><?=$good['status'] == 1 ? '显示':'隐藏';?></td>
        <td><?=$good['sort']?></td>
        <td><?=date('Y-m-d h:i:s',$good['create_time'])?></td>
        <td><?=$good['view_times']?></td>
        <td>
            <?=\yii\bootstrap\Html::a('预览',['goods/info','id'=>$good['id']],['class'=>'btn btn-sm btn-info'])?>
            <?=\yii\bootstrap\Html::a('相册',['goods/photo','id'=>$good['id']],['class'=>'btn btn-sm btn-success'])?>
            <?=\yii\bootstrap\Html::a('修改',['goods/edit','id'=>$good['id']],['class'=>'btn btn-sm btn-info'])?>
            <?=\yii\bootstrap\Html::a('删除',['goods/delete','id'=>$good['id']],['class'=>'btn btn-sm btn-danger'])?>
        </td>
    </tr>
    <?php endforeach;?>
</table>
<?php
//分页工具条*/
echo \yii\widgets\LinkPager::widget(['pagination'=>$pager,'nextPageLabel'=>'下一页','prevPageLabel'=>'上一页','firstPageLabel'=>'首页']);