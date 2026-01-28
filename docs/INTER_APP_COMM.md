Inter-App Communication (Core)

Kurzfassung
- Dieses Dokument beschreibt ein leicht gekoppeltes Event-Modell für Inter-App-Kommunikation.

Modell
- Apps senden Events (Basic, Callback, RequestData).
- Callback-Events erlauben, dass der Sender eine Callback-Funktion mitgibt.
- RequestData-Events dienen dazu, dass Empfänger Daten zurückgeben (über Callback).

Versionierung
- Events sind stabilisierte Klassen. Breaking-Changes erfordern Versionierung im Klassennamen oder Feldnamen.

Beispiele
- Sender (Basic):
```
$eventService->dispatchBasicEvent(['foo'=>'bar']);
```

- Sender (Callback):
```
$eventService->dispatchCallbackEvent(['id'=>123], function($resp){ /* handle */ });
```

- Listener (Callback):
```
public function handle(CallbackEvent $e) {
  $e->triggerCallback(['ok'=>true]);
}
```

Hinweis
- Keine direkten App-Dependencies: Kommunikation ausschließlich über Events.
