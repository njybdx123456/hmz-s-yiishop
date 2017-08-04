<?=\yii\bootstrap\Html::a('添加',['goods-category/add2'],['class'=>'btn btn-sm btn-info'])?>
<table class="table table-bordered table-striped">
    <tr>
        <th>ID</th>
        <th>名称</th>
        <th>parent_id</th>
        <th>简介</th>
        <th>操作</th>
    </tr>
    <?php foreach($model as $goods):?>
    <tr>
        <td><?=$goods->id?></td>
        <td><?=$goods->name?></td>
        <td><?=$goods->parent_id?></td>
        <td><?=$goods->intro?></td>
        <td>
            <?=\yii\bootstrap\Html::a('修改',['goods-category/edit','id'=>$goods->id],['class'=>'btn btn-sm btn-success'])?>
            <?=\yii\bootstrap\Html::a('删除',['goods-category/delete','id'=>$goods->id],['class'=>'btn btn-sm btn-danger'])?>
        </td>
    </tr>
    <?php endforeach;?>
</table>
<?php
//分页工具条*/
echo \yii\widgets\LinkPager::widget(['pagination'=>$pager,'nextPageLabel'=>'下一页','prevPageLabel'=>'上一页','firstPageLabel'=>'首页']);