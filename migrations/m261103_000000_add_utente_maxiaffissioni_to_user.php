<?php

use yii\db\Migration;

/**
 * Aggiunge il flag `utente_maxiaffissioni` all'anagrafica utente.
 * Se attivo, la home mostra la nuova pagina con le card delle commesse;
 * altrimenti viene mantenuta la vecchia dashboard.
 */
class m261103_000000_add_utente_maxiaffissioni_to_user extends Migration
{
    public function safeUp()
    {
        $table = $this->db->getTableSchema('user', true);

        if ($table !== null && $table->getColumn('utente_maxiaffissioni') === null) {
            $this->addColumn('user', 'utente_maxiaffissioni', $this->boolean()->notNull()->defaultValue(0));
        }
    }

    public function safeDown()
    {
        $table = $this->db->getTableSchema('user', true);

        if ($table !== null && $table->getColumn('utente_maxiaffissioni') !== null) {
            $this->dropColumn('user', 'utente_maxiaffissioni');
        }
    }
}
