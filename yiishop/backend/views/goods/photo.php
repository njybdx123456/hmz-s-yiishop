<table class="table table-bordered table-striped">
    <tr>
        <th>Id</th>
        <th>商品ID</th>
        <th>图片</th>
        <th>操作</th>
    </tr>
    <?php foreach($model as $p):?>
    <tr>
        <td><?=$p['id']?></td>
        <td><?=$p['goods_id']?></td>
        <td><?=\yii\bootstrap\Html::img($p['path'])?></td>
        <td>
            <?=\yii\bootstrap\Html::a('删除',['goods/del_img','id'=>$p['id'],'goods_id'=>$p['goods_id']],['class'=>'btn btn-sm btn-danger'])?>
        </td>
    </tr>
    <?php endforeach;?>
</table>