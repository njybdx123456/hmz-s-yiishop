<table class="table table-bordered table-striped">
    <tr>
        <th>商品ID</th>
        <th>内容详情</th>
    </tr>
    <tr>
        <td><?=$model->goods_id?></td>
        <td><?=$model->content?></td>
    </tr>
</table>
<?=\yii\bootstrap\Html::a('添加图片',['goods/add_photo','id'=>$model->goods_id],['class'=>'btn btn-sm btn-success'])?>
<?=\yii\bootstrap\Html::a('回返',['goods/index'],['class'=>'btn btn-sm btn-info'])?>