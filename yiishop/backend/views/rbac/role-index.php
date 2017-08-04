<?=\yii\bootstrap\Html::a('添加权限',['rbac/add-role'],['class'=>'btn btn-sm btn-info'])?>
<table class=" table-bordered table-striped">
        <tr>
            <th>名称</th>
            <th>描述</th>
            <th>操作</th>
        </tr>
    <?php foreach($model as $sth):?>
        <tr>
            <td><?=$sth->name?></td>
            <td><?=$sth->description?></td>
            <td>
                <?=\yii\bootstrap\Html::a('角色修改',['rbac/edit-role','name'=>$sth->name],['class'=>'btn btn-sm btn-info'])?>
                <?=\yii\bootstrap\Html::a('角色删除',['rbac/delete-role','name'=>$sth->name],['class'=>'btn btn-sm btn-info'])?>
            </td>
        </tr>
    <?php endforeach;?>
</table>

