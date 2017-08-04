<?=\yii\bootstrap\Html::a('添加权限',['rbac/add-permission'],['class'=>'btn btn-sm btn-info'])?>
<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>名称</th>
            <th>描述</th>
            <th>操作</th>
        </tr>
    </thead>

    <tbody>
    <?php foreach($model as $sth):?>
        <tr>
            <td><?=$sth->name?></td>
            <td><?=$sth->description?></td>
            <td>
                <?=\yii\bootstrap\Html::a('修改权限',['rbac/edit-permission','name'=>$sth->name],['class'=>'btn btn-sm btn-info'])?>
                <?=\yii\bootstrap\Html::a('删除权限',['rbac/delete-permission','name'=>$sth->name],['class'=>'btn btn-sm btn-info'])?>
            </td>
        </tr>
    <?php endforeach;?>
    </tbody>
</table>
<?php
/**
 * @var $this \yii\web\View
 */
//$this->registerCssFile('//cdn.datatables.net/1.10.15/css/jquery.dataTables.min.css');
$this->registerCssFile('//cdn.datatables.net/1.10.15/css/dataTables.bootstrap.css');
$this->registerJsFile('//cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js',['depends'=>\yii\web\JqueryAsset::className()]);
$this->registerJsFile('//cdn.datatables.net/1.10.15/js/dataTables.bootstrap.js',['depends'=>\yii\web\JqueryAsset::className()]);
$this->registerJs('$(".table").DataTable({
language: {
        url: "//cdn.datatables.net/plug-ins/1.10.15/i18n/Chinese.json"
    }
});');