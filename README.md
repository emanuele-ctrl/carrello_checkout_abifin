# Mini Shop — Carrello e Checkout

Prova tecnica per Abifin SRL — Sviluppatore Junior.

## Stack utilizzato

- PHP 8.2+
- Laravel 12
- Inertia.js + React 18
- Tailwind CSS
- SQLite
- PHPUnit (test automatici)

## Requisiti per l'installazione

- PHP >= 8.2 con estensioni: `sqlite3`, `pdo_sqlite`, `mbstring`, `openssl`, `fileinfo`, `curl`
- Composer
- Node.js >= 18 e npm

## Istruzioni di installazione e avvio

1. Clonare il repository:
bash
   git clone https://github.com/emanuele-ctrl/carrello_checkout_abifin.git
   cd carrello_checkout_abifin


2. Installare le dipendenze PHP:
bash
   composer install


3. Installare le dipendenze JavaScript:
bash
   npm install


4. Copiare il file di ambiente e generare la chiave dell'applicazione:
bash
   cp .env.example .env
   php artisan key:generate


5. Creare il file del database SQLite:
bash
   touch database/database.sqlite

   (su Windows, se `touch` non è disponibile: creare manualmente un file vuoto in quel percorso)

6. Eseguire le migrazioni e popolare il database con i dati di esempio:
bash
   php artisan migrate --seed

   Dopo questo comando l'applicazione è immediatamente navigabile, con 14 prodotti già disponibili (di cui 2 con stock a 0, utili per testare il comportamento "prodotto esaurito").

7. Avviare i due processi necessari, in due terminali separati:

   **Terminale 1** — server Laravel:
bash
   php artisan serve


   **Terminale 2** — build frontend in modalità sviluppo:
bash
   npm run dev


8. Aprire il browser su `http://localhost:8000`.

## Credenziali di test

Non è richiesta alcuna autenticazione: il catalogo e il carrello sono liberamente accessibili. Non sono quindi necessarie credenziali.

## Scelte implementative

- **Prezzi in centesimi**: tutti gli importi (`price_cents`, `unit_price_cents`, `total_cents`, `shipping_cents`) sono memorizzati come interi in centesimi, invece che come numeri decimali, per evitare i classici problemi di arrotondamento dei float con valori monetari.
- **Carrello in sessione**: il carrello è salvato come array `[product_id => quantità]` nella sessione del server (`CartService`), come richiesto dalla traccia ("persistente in sessione durante la navigazione tra le pagine"). Non è stata creata una tabella database dedicata al carrello, perché non richiesta e non necessaria per un carrello temporaneo legato alla singola sessione.
- **Calcolo totale centralizzato**: il calcolo di subtotale, spese di spedizione e totale è isolato in un'unica classe di servizio, `CartCalculator`, riutilizzata dalla pagina carrello. Questo garantisce che il calcolo lato server sia sempre coerente e mai duplicato o delegato al frontend.
- **Soglia spedizione**: spedizione gratuita per un totale merce pari o superiore a 50€, altrimenti costo fisso di 6,90€.
- **Vincoli quantità carrello**: sia in fase di aggiunta sia di modifica, la quantità è sempre vincolata tra 1 e lo stock disponibile del prodotto, applicato lato server in `CartService` (non solo lato client), così il vincolo non è aggirabile.
- **Stato carrello vuoto dedicato**: la pagina carrello mostra un messaggio e un link al catalogo quando non ci sono articoli, invece di una tabella vuota, come richiesto dalla traccia.
- **Contatore carrello globale**: il numero di articoli nel carrello è condiviso automaticamente a tutte le pagine tramite le props condivise di Inertia (`HandleInertiaRequests`), ed è sempre visibile nell'header del layout.
- **Relazioni Eloquent**: `Order hasMany OrderItem`, `OrderItem belongsTo Order` e `belongsTo Product`, secondo il modello richiesto dalla traccia ("un ordine ha molte righe; una riga appartiene a un prodotto").
- **Autenticazione non utilizzata**: lo starter kit ufficiale di Laravel include di default tabelle e funzionalità di autenticazione utenti (login, passkey, 2FA). Non sono state rimosse, ma non vengono utilizzate in alcun punto dell'applicazione: il mini-shop non richiede login, come specificato dalla traccia.

## Cosa non è stato completato

Per limiti di tempo, le seguenti funzionalità richieste dalla traccia **non sono state completate**:

- **Checkout**: form di checkout, validazione server-side, creazione dell'ordine con transazione database e controllo dello stock al momento dell'acquisto.
- **Pagina di riepilogo ordine**: visualizzazione dell'ordine tramite codice univoco.
- **Test automatici**: feature test per la creazione di un ordine e per il blocco in caso di stock insufficiente.

**Motivazione**: la prova tecnica è stata affrontata dando priorità a un modello dati solido e a una gestione del carrello corretta e ben compresa, piuttosto che completare tutte le funzionalità in modo affrettato e meno sicuro. Come indicato nella traccia stessa ("è preferibile consegnare meno funzionalità ma realizzate bene piuttosto che tutte incomplete"), si è preferito consegnare le parti completate con la certezza di saperle spiegare in dettaglio, anziché aggiungere codice su checkout e test senza averne piena padronanza nel tempo rimasto.

Le parti mancanti seguono comunque un disegno già definito, appoggiandosi ai servizi già scritti:
- Il checkout riutilizzerebbe `CartCalculator` per il calcolo del totale finale e `CartService` per leggere e poi svuotare il carrello.
- La creazione dell'ordine avverrebbe dentro una transazione database (`DB::transaction`), salvando `unit_price_cents` per ogni riga (prezzo al momento dell'acquisto) e scalando lo stock dei prodotti acquistati.
- In caso di stock insufficiente rilevato al momento della conferma, l'ordine non verrebbe creato e l'utente sarebbe reindirizzato al carrello con un messaggio di errore.