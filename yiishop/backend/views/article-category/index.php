<?=\yii\bootstrap\Html::a('添加',['article-category/add'],['class'=>'btn btn-info btn-sm'])?>
<table  class="table table-bordered table-striped">
    <tr>
        <th>id</th>
        <th>名称</th>
        <th>排序</th>
        <th>状态</th>
        <th>简介</th>
        <th>操作</th>
    </tr>
    <?php foreach($model as $article):?>
    <tr>
        <td><?=$article->id?></td>
        <td><?=$article->name?></td>
        <td><?=$article->sort?></td>
        <td><?=$article->status?></td>
        <td><?=$article->intro?></td>
        <td>
            <?=\yii\bootstrap\Html::a('修改',['article-category/edit','id'=>$article->id],['class'=>'btn btn-info btn-sm'])?>
            <?=\yii\bootstrap\Html::a('删除',['article-category/delete','id'=>$article->id],['class'=>'btn btn-info btn-sm'])?>
        </td>
    </tr>
    <?php endforeach;?>
</table>
<?php
//分页工具条
echo \yii\widgets\LinkPager::widget(['pagination'=>$pager,'nextPageLabel'=>'下一页','prevPageLabel'=>'上一页','firstPageLabel'=>'首页']);