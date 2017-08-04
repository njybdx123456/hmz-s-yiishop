<?php
/**
 * 登录表单
 */
$form=\yii\bootstrap\ActiveForm::begin();
echo $form->field($login,'username');
echo $form->field($login,'password')->passwordInput();
echo $form->field($login,'code')->widget(\yii\captcha\Captcha::className(),['captchaAction'=>['admin/captcha']]);
echo $form->field($login,'rememberMe')->checkbox();
echo \yii\bootstrap\Html::submitButton('登录',['class'=>'btn btn-sm btn-success']);
\yii\bootstrap\ActiveForm::end();