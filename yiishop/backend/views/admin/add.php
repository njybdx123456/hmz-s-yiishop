<?php
$form=\yii\bootstrap\ActiveForm::begin();
echo $form->field($adminModel,'username');
echo $form->field($adminModel,'password_hash')->passwordInput();
echo $form->field($adminModel,'email');
echo $form->field($adminModel,'roles')->checkboxList(
    \yii\helpers\ArrayHelper::map(\Yii::$app->authManager->getRoles(),'name','name')
);
//判断是修改还是添加    若不是修改就显示权限选择
//if(!$adminModel->isNewRecord){
//    echo $form->field($adminModel,'status',['inline'=>1])->radioList(\backend\models\Admin::$status);
//}
echo \yii\bootstrap\Html::submitButton('提交',['class'=>'btn btn-sm btn-info']);
\yii\bootstrap\ActiveForm::end();