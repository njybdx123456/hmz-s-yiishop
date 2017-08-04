<?php
$form=\yii\bootstrap\ActiveForm::begin();
echo $form->field(\Yii::$app->user->identity,'username')->textInput(['class'=>'form-control','readonly'=>'readonly']);
echo $form->field($model,'oldPassword')->passwordInput();
echo $form->field($model,'newPassword')->passwordInput();
echo $form->field($model,'rePassword')->passwordInput();
echo \yii\bootstrap\Html::submitButton('确认修改',['class'=>'btn btn-sm btn-info']);
\yii\bootstrap\ActiveForm::end();