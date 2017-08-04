<?php
$form=\yii\bootstrap\ActiveForm::begin();
echo $form->field($models,'name');
echo $form->field($models,'parent_id');
echo $form->field($models,'intro');
echo \yii\bootstrap\Html::submitButton('提交',['class'=>'btn btn-sm btn-info']);
\yii\bootstrap\ActiveForm::end();