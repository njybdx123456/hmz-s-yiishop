<?php
$form=\yii\bootstrap\ActiveForm::begin();
echo $form->field($model,'name');
echo $form->field($model,'article_category_id')->dropDownList(\backend\models\Article::getArray());
echo $form->field($model,'intro');
echo $form->field($model,'status',['inline'=>1])->radioList(\backend\models\Article::getStatusOptions());
echo $form->field($model,'sort');
echo $form->field($models,'content')->textarea(['rows'=>12]);
echo \yii\bootstrap\Html::submitButton('提交',['class'=>'btn btn-info btn-sm']);
\yii\bootstrap\ActiveForm::end();