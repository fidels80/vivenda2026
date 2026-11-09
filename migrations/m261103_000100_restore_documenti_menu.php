<?php

use yii\db\Migration;
use yii\db\Query;

/**
 * Ripristina la voce di primo livello `Documenti` in `xmenu`.
 *
 * I sottomenu `Elenco`, `Righe`, `creadoc` e `preventivi` sono già presenti
 * in `xsubmenu` con `id_menu = 3`, ma la relativa voce padre in `xmenu`
 * risultava mancante: senza di essa il menu Documenti -> Elenco non viene
 * mostrato a nessun utente.
 */
class m261103_000100_restore_documenti_menu extends Migration
{
    public function safeUp()
    {
        $db = $this->db;

        $documenti = (new Query())
            ->select('id')
            ->from('xmenu')
            ->where(['voce' => 'Documenti'])
            ->one($db);

        if ($documenti !== false && $documenti !== null) {
            $menuId = (int) $documenti['id'];
        } else {
            // Normalmente il padre dei documenti è la voce con id 3.
            $menuId = 3;
            $existing = (new Query())
                ->select('id')
                ->from('xmenu')
                ->where(['id' => $menuId])
                ->one($db);

            if ($existing !== false && $existing !== null) {
                $menuId = ((int) (new Query())->from('xmenu')->max('id', $db)) + 1;
            }

            $this->insert('xmenu', [
                'id' => $menuId,
                'voce' => 'Documenti',
                'azione' => '0',
                'level' => 70,
                'url' => '/doc_head',
                'icona' => 'file',
                'Nmodulo' => null,
                'Nreport' => null,
            ]);
        }

        if ($menuId !== 3) {
            $this->update('xsubmenu', ['id_menu' => $menuId], ['id_menu' => 3]);
        }
    }

    public function safeDown()
    {
        // Non rimuoviamo la voce Documenti: è configurazione applicativa e
        // potrebbe essere referenziata da altri sottomenu.
    }
}
