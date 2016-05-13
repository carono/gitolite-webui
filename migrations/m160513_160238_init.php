<?php

use yii\db\Migration;

class m160513_160238_init extends Migration
{
    public function up()
    {
        $this->createTable(
            'gitolite', [
                'id'   => self::primaryKey(),
                'name' => self::string()->notNull(),
                'path' => self::string(1024)->notNull()->unique()
            ]
        );
    }

    public function down()
    {
        echo "m160513_160238_init cannot be reverted.\n";

        return false;
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
