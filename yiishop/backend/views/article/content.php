<table class="table table-bordered table-striped">
    <tr>
        <th>文章ID</th>
        <th>内容</th>
    </tr>
    <tr>
        <td><?=$model->article_id?></td>
       <td><?=$model->content?></td>
    </tr>
</table>
    <?=\yii\bootstrap\Html::a('回返',['article/index'],['class'=>'btn btn-sm btn-info'])?>
