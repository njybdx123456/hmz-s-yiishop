<?php
$form=\yii\bootstrap\ActiveForm::begin();
echo $form->field($model,'name');
echo $form->field($model,'description')->textInput();
echo $form->field($model,'permissions',['inline'=>1])->checkboxList(
    \yii\helpers\ArrayHelper::map(Yii::$app->authManager->getPermissions(),'name','description'));
echo \yii\helpers\Html::submitButton('确认',['class'=>'btn btn-info btn-sm']);
\yii\bootstrap\ActiveForm::end();