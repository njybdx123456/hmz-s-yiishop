
<h1>管理员列表</h1>
<?=\yii\helpers\Html::a('添加管理员',['admin/add'],['class'=>'btn btn-sm btn-info'])?>
<table class="table table-bordered table-striped">
    <tr>
        <th>ID</th>
        <th>管理员名称</th>
        <th>邮箱</th>
        <th>状态</th>
        <th>最后登录时间</th>
        <th>最后登录IP</th>
        <th>操作</th>
    </tr>
    <?php foreach($model as $models):?>
    <tr>
        <td><?=$models->id?></td>
        <td><?=$models->username?></td>
        <td><?=$models->email?></td>
        <td><?=$models->status == 1 ? '显示':'隐藏';?></td>
        <td><?=date('Y-m-d H:i:s',$models->last_login_time)?></td>
        <td><?=long2ip($models->last_login_ip)?></td>
        <td>
            <?=\yii\helpers\Html::a('修改',['admin/edit','id'=>$models->id],['class'=>'btn btn-sm btn-success'])?>
            <?=\yii\helpers\Html::a('删除',['admin/delete','id'=>$models->id],['class'=>'btn btn-sm btn-danger'])?>
        </td>
    </tr>
    <?php endforeach;?>
</table>