<?php
namespace backend\models;
use yii\db\ActiveRecord;

class ArticleContent extends ActiveRecord{
    public function rules(){
        return [
            [['content'],'required'],
            [['content'], 'string'],
        ];
    }
    public function attributeLabels(){
        return [
            'article_id' => '文章ID',
            'content' => '文章内容',
        ];
    }
}