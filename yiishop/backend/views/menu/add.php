<?php
$form=\yii\bootstrap\ActiveForm::begin();
echo $form->field($menu,'name')->textInput();
echo $form->field($menu,'parent_id')->dropDownList(\backend\models\Menu::getMenuOption(),['prompt' => '=请选择上级菜单=']);
echo $form->field($menu,'route')->dropDownList(\backend\models\Menu::getPermissionOption(),['prompt' => '=请选择路由=']);
echo \yii\bootstrap\Html::submitButton('提交',['class'=>'btn btn-sm btn-info']);
\yii\bootstrap\ActiveForm::end();