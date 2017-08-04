<h1><添加 修改 权限><h1/>

<?php
$form=\yii\bootstrap\ActiveForm::begin();
echo $form->field($model,'name');
echo $form->field($model,'description')->textInput();
echo \yii\helpers\Html::submitButton('确认',['class'=>'btn btn-info btn-sm']);
\yii\bootstrap\ActiveForm::end();