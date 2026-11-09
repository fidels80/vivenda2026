<?php

use yii\db\Migration;

/**
 * Crea la tabella `commessa_cover` per le immagini copertina delle sottocommesse.
 */
class m261019_000000_create_commessa_cover_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('commessa_cover', [
            'id' => $this->primaryKey(),
            'cd_dosottocommessa' => $this->string(20)->notNull()->unique(),
            'image_path' => $this->string(255)->notNull(),
            'created_at' => $this->dateTime(),
            'updated_at' => $this->dateTime(),
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('commessa_cover');
    }
}
