<?php

use yii\db\Migration;

/**
 * Handles the creation of table `admin`.
 */
class m170718_094218_create_brand_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB COMMENT="品牌表"';
        }
        $this->createTable('brand', [
            'id' => $this->primaryKey(),
            'name'=>$this->string(30),
//            name	varchar(50)	名称
            'intro'=>$this->text(),
//            intro	text	简介
            'logo'=>$this->string(255),
//            logo	varchar(255)	LOGO图片
            'sort'=>$this->smallInteger(11),
//            sort	int(11)	排序
            'status'=>$this->smallInteger(2),
//            status	int(2)	状态(-1删除 0隐藏 1正常)
        ],$tableOptions);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('brand');
    }
}
