<?=\yii\bootstrap\Html::a('添加',['brand/add'],['class'=>'btn btn-info btn-sm'])?>&emsp;
<table class="table table-bordered table-striped">
    <tr>
        <th>id</th>
        <th>品牌名称</th>
        <th>状态</th>
        <th>排序</th>
        <th>logo</th>
        <th>简介</th>
        <th>操作</th>
    </tr>
    <?php foreach($model as $admin):?>
    <tr>
        <td><?=$admin->id?></td>
        <td><?=$admin->name?></td>
        <td><?=\backend\models\Brand::getStatusOptions(false)[$admin->status]?></td>
        <td><?=$admin->sort?></td>
        <td><?=\yii\bootstrap\Html::img($admin->logo,['height'=>60])?></td>
        <td><?=$admin->intro?></td>
        <td>
            <?=\yii\bootstrap\Html::a('修改',['brand/edit','id'=>$admin->id],['class'=>'btn btn-info btn-sm'])?>
            <?=\yii\bootstrap\Html::a('删除',['brand/delete','id'=>$admin->id],['class'=>'btn btn-danger btn-sm'])?>
        </td>
    </tr>
    <?php endforeach;?>
</table>
<?php
//分页工具条
echo \yii\widgets\LinkPager::widget(['pagination'=>$pager,'nextPageLabel'=>'下一页','prevPageLabel'=>'上一页','firstPageLabel'=>'首页']);