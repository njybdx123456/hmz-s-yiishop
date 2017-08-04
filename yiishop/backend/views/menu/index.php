<?=\yii\bootstrap\Html::a('添加',['menu/add'],['class'=>'btn btn-sm btn-success'])?>
<table class="table table-bordered table-striped">
    <tr>
        <th>ID</th>
        <th>名称</th>
        <th>路由</th>
        <th>上级菜单</th>
        <th>操作</th>
    </tr>
    <?php foreach($menus as $model):?>
    <tr>
        <td><?=$model->id?></td>
        <td><?=$model->name?></td>
        <td><?=$model->route?></td>
        <td><?=$model->parent_id?></td>
        <td>
            <?=\yii\bootstrap\Html::a('修改',['menu/edit','id'=>$model->id],['class'=>'btn btn-sm btn-info'])?>
            <?=\yii\bootstrap\Html::a('删除',['menu/delete','id'=>$model->id],['class'=>'btn btn-sm btn-danger'])?>
        </td>
    </tr>
    <?php endforeach;?>
</table>

<?php
//分页工具条*/
echo \yii\widgets\LinkPager::widget(['pagination'=>$pager,'nextPageLabel'=>'下一页','prevPageLabel'=>'上一页','firstPageLabel'=>'首页']);