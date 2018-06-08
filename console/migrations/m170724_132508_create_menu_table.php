<?php

use yii\db\Migration;

/**
 * Handles the creation of table `menu`.
 */
class m170724_132508_create_menu_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('menu', [
            'id' => $this->primaryKey(),
            'label'=>$this->string(),
            'link'=>$this->string(),
            'order'=>$this->integer(),
            'parent_id'=>$this->integer()
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('menu');
    }
}
