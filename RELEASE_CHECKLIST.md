RELEASE CHECKLIST

- [x] Version in `appinfo/info.xml` aktualisiert
- [ ] `CHANGELOG.md` aktualisiert
- [ ] Tests lokal ausgeführt
- [ ] Composer-Abhängigkeiten geprüft
- [ ] Übersetzungen aktualisiert
- [x] Build-Prozess (falls vorhanden) ausgeführt
- [ ] Security-Review durchgeführt
- [ ] Release-Tag im Repository erstellt
# Release-Ready Checkliste

## 1. Codequalität & Struktur
- [x] App folgt der Nextcloud-App-Struktur
- [ ] Keine direkten OCA-Abhängigkeiten zu anderen Apps
- [x] Inter-App-Kommunikation ausschließlich über Events + Callbacks
- [ ] Keine deprecated APIs
- [ ] QueryBuilder statt direkter SQL-Queries
- [ ] Keine Schreibzugriffe außerhalb des App-Ordners
- [ ] Keine Debug-Ausgaben

## 2. Datenbank
- [ ] Tabellen über Migrationsdateien definiert
- [ ] Fremdschlüssel haben Indizes
- [ ] Pagination in allen Listen-Abfragen
- [ ] Keine SELECT * Queries
- [ ] Keine N+1-Queries
- [ ] DB-Schema dokumentiert

## 3. Events & Callbacks
- [x] App sendet eigene Events
- [x] App empfängt Events anderer Apps
- [x] Callback-fähige Events implementiert
- [x] Listener in Application.php registriert
- [x] Events versionierbar

## 4. API / OCS-Routes
- [ ] OCS-Response-Objekte verwendet
- [ ] Pagination unterstützt
- [ ] Fehlerbehandlung vorhanden
- [ ] API dokumentiert
- [ ] Berechtigungen geprüft

## 5. UI / Frontend
- [x] Vue-Build funktioniert
- [x] Responsives Layout
- [ ] Barrierefreiheit berücksichtigt
- [ ] Fehlermeldungen und Ladezustände vorhanden

## 6. Sicherheit
- [ ] CSRF-Schutz aktiv
- [ ] Upload-MIME-Types geprüft
- [ ] Berechtigungen geprüft
- [ ] Keine sensiblen Daten im Log
- [ ] Keine externen Requests ohne Zustimmung

## 7. DSGVO
- [ ] Datenminimierung
- [ ] Exportfunktion vorhanden
- [ ] Löschkonzept implementiert
- [ ] Keine externen Dienste
- [ ] Privacy by Design dokumentiert

## 8. Dokumentation
- [x] README.md vollständig
- [ ] CHANGELOG.md vorhanden
- [x] INTER_APP_COMM.md vorhanden
- [ ] Screenshots erstellt
- [ ] Installationsanleitung vorhanden

## 9. Tests
- [ ] Unit-Tests vorhanden
- [ ] Event-Tests vorhanden
- [ ] API-Tests vorhanden
- [ ] Linting ohne Fehler
- [ ] CI-Pipeline erfolgreich

## 10. Release-Vorbereitung
- [ ] Version in appinfo/info.xml aktualisiert
- [ ] Git-Tag erstellt
- [ ] App signiert
- [ ] Signaturdateien im Repo
- [ ] GitHub-Release erstellt
- [ ] Store-Beschreibung vorbereitet
