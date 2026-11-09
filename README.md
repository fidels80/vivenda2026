# Vivenda Portal

Applicazione web gestionale sviluppata con **Yii 2** (Basic Project Template) per la gestione
di commesse, documenti, pubblicazioni, clienti, agenda, presenze e magazzino.

Il repository: <https://github.com/fidels80/vivenda2026>

## Tecnologie

- **PHP** (Yii 2 richiede >= 5.6, il progetto usa anche Codeception 5)
- **Yii 2** `~2.0.14`
- **AdminLTE 3** + **Bootstrap 4** per l'interfaccia
- **KoolReport**, **Chart.js**, **Kartik widgets** (grid, select2, datepicker, export, mPDF, ...)
- **SQL Server** (Arca Evolution) tramite driver PDO `sqlsrv`
- **Codeception** per i test

## Struttura del repository

| Directory | Contenuto |
|---|---|
| `assets/` | Definizione degli asset bundle |
| `auto_update/` | Script SQL di supporto (`tbl_brand`, `tbl_group`, `tbl_shop`, `xmenu`, `xaction`, ...) |
| `commands/` | Comandi console |
| `config/` | Configurazione applicazione (`web.php`, `console.php`, `params.php`, `env.php`) |
| `controllers/` | Controller web |
| `mail/` | View per le email |
| `migrations/` | Migrazioni del database |
| `models/` | Modelli e classi di ricerca |
| `modules/` | Moduli applicativi |
| `reports/` | Report |
| `runtime/` | File generati a runtime (escluso da Git) |
| `tests/` | Test Codeception |
| `vagrant/`, `Vagrantfile` | Ambiente di sviluppo Vagrant |
| `views/` | View dell'applicazione |
| `web/` | Entry script e risorse web |
| `widgets/` | Widget personalizzati |
| `xml/` | File XML di supporto |

## Moduli applicativi

I moduli registrati in `config/web.php`:

- **autoupdate** — gestione tabelle di configurazione (brand, gruppi, negozi, menu, azioni)
- **warehouse** — magazzino (articoli, proprietà, store)
- **presenze** — gestione presenze e transazioni
- **chart** — grafici e tabelle di analisi
- `dintable` — presente nel codice ma non attivo

## Funzionalità principali

I controller in `controllers/` coprono:

- **Documenti**: `Doc_headController`, `Doc_rowsController`, `DocType`/`DmsDocument`
- **Clienti e relazioni**: `AnacliController`, `RelcliController`
- **Commesse e sottocommesse**: `SottocommessaController`, `CommessaCover`
- **Agenda e calendario**: `AgendaController`, `AgendaFilesController`, `CalController`, `BookController`
- **Pubblicazioni**: `Rep_publicazioniController`, `ReportsController`
- **File e upload**: `FilesController`, `FilesFormController`, `AllfilesController`
- **Pagamenti e locazioni**: `PaymentsController`, `LocazioniController`
- **Amministrazione**: `UserController`, `UsrGrpController`, `XmenuController`, `XsubmenuController`, `XactionController`, `LogController`
- **API / servizi**: `RestController`, `ElemailController`

## Modelli principali

`Doc_head`, `Doc_rows`, `AnaCli`, `Agenda`, `AgendaFiles`, `Book`, `Cal`, `CommessaCover`,
`DmsDocument`, `DocType`, `DORig`, `DorighOcp`, `Elemail`, `Files`, `Items`, `Locazioni`,
`Log`, `Payments`, `Relcli`, `Relusrformaction`, `Rep_publicazioni`, `User`, `UsrGrp`,
`Xaction`, `Xmenu`, `Xsubmenu`.

## Configurazione

La configurazione dell'applicazione è in `config/`:

- `web.php` — configurazione web (moduli, URL, componenti)
- `console.php` — configurazione console
- `params.php` — parametri applicativi (email, plugin AdminLTE)
- `env.php` — parametri ambiente (es. stati commessa `stati_commesse`)

La connessione al database si configura in `config/db.php` (connessione SQL Server).
**Nota:** `config/db.php` è volutamente escluso dal versionamento perché contiene credenziali.

## Installazione

```bash
composer install
```

Configurare `config/db.php` con i parametri del database SQL Server, quindi applicare le migrazioni:

```bash
php yii migrate
```

Avviare l'applicazione puntando il web server alla cartella `web/`.

## Migrazioni

- `m161209_144250_create_user_table`
- `m261019_000000_create_commessa_cover_table`
- `m261103_000000_add_utente_maxiaffissioni_to_user`
- `m261103_000100_restore_documenti_menu`
- `m261104_000000_restore_maxiaffissioni_menu`

## Test

I test usano [Codeception](https://codeception.com/):

```bash
vendor/bin/codecept run
```
