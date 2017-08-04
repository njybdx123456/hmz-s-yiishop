<?=\yii\bootstrap\Html::a('添加',['article/add'],['class'=>'btn btn-info btn-sm'])?>
<table class="table table-bordered">
    <tr>
        <th>ID</th>
        <th>名称</th>
        <th>文章分类id</th>
        <th>简介</th>
        <th>排序</th>
        <th>状态</th>
        <th>创建时间</th>
        <th>操作</th>
    </tr>
    <?php foreach($model as $article):?>
    <tr>
        <td><?= $article->id ?></td>
        <td><?= $article->name ?></td>
        <td><?= $article->article_category_id ?></td>
        <td><?= $article->intro ?></td>
        <td><?= $article->sort ?></td>
        <td><?= \backend\models\Article::getStatusOptions(false)[$article->status] ?></td>
        <td><?= date('Ymd H:i:s',$article->create_time) ?></td>
        <td>
            <?=\yii\bootstrap\Html::a('修改',['article/edit','id'=>$article->id],['class'=>'btn btn-info btn-sm'])?>
            <?=\yii\bootstrap\Html::a('删除',['article/delete','id'=>$article->id],['class'=>'btn btn-danger btn-sm'])?>
            <?=\yii\bootstrap\Html::a('内容详情',['article/info','id'=>$article->id],['class'=>'btn btn-danger btn-sm'])?>
        </td>
    </tr>
    <?php endforeach;?>
</table>

<?php
//分页工具条
echo \yii\widgets\LinkPager::widget(['pagination'=>$pager,'nextPageLabel'=>'下一页','prevPageLabel'=>'上一页','firstPageLabel'=>'首页']);