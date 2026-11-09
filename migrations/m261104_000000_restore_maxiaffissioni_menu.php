<?php

use yii\db\Migration;
use yii\db\Query;

/**
 * Ripristina la voce di primo livello `Maxi Affissioni` in `xmenu`.
 *
 * I sottomenu `Maxi Affissioni`, `Operatori`, `Gantt` e `Prenota` sono già
 * presenti in `xsubmenu` con `id_menu = 2`, ma la relativa voce padre in
 * `xmenu` risultava mancante. Senza di essa la voce non viene mostrata a
 * nessun utente, anche se presente nei moduli dell'utente.
 */
class m261104_000000_restore_maxiaffissioni_menu extends Migration
{
    public function safeUp()
    {
        $db = $this->db;

        $menu = (new Query())
            ->select('id')
            ->from('xmenu')
            ->where(['voce' => 'Maxi Affissioni'])
            ->one($db);

        if ($menu !== false && $menu !== null) {
            $menuId = (int) $menu['id'];
        } else {
            $menuId = 2;
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
                'voce' => 'Maxi Affissioni',
                'azione' => '0',
                'level' => 70,
                'url' => '/',
                'icona' => 'bullhorn',
                'Nmodulo' => null,
                'Nreport' => null,
            ]);
        }

        if ($menuId !== 2) {
            $this->update('xsubmenu', ['id_menu' => $menuId], ['id_menu' => 2]);
        }
    }

    public function safeDown()
    {
        // La voce è configurazione applicativa: non la rimuoviamo.
    }
}
