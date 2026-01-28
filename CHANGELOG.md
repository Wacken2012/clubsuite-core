# Changelog
Alle Änderungen an dieser App werden in diesem Dokument festgehalten.
Format basiert auf Keep a Changelog.

## [1.2.0-rc1] - 2026-01-16
### Release Candidate
- **Stability**: Codebase hardened for production use.
- **Compliance**: Full GDPR/DSGVO compliance verified (Privacy API).
- **Security**: Role-Based Access Control (RBAC) enforced on all controllers.
- **Packaging**: Clean build artifacts, removed dev dependencies.

## [1.1.0] - 2024-05-21
### Added
- **Compliance**: DSGVO-konforme Datenexport- und Löschfunktionen (Privacy API).
- **Security**: Erweiterte Zugriffskontrollen (`checkPermissions`) in Controllern.
- **Logging**: Strukturierte Audit-Logs für alle Schreibvorgänge.
- **L10n**: Verbesserte Übersetzungen.
- Detailansicht für Mitglieder (/members/{id}/detail)
- Erweiterte Stammdaten (Straße, PLZ, Ort, Telefon, E-Mail)
- Bearbeiten-Funktion in Detailansicht integriert
- Navigation zu allen ClubSuite-Apps in der Seitenleiste
- Bearbeiten-Dialog in der Mitgliederliste hinzugefügt
- Suchfunktion für Mitglieder

## [0.1.0] – Initial Release
### Added
- Erste stabile Version der App
- Vollständige Integration in das ClubSuite-Ökosystem
- Vue-Frontend
- PageController
- OCS-API
- Event-basierte Inter-App-Kommunikation
- Callback-Events
- DSGVO-konforme Datenverarbeitung
- Icons und Branding
- Lizenz: AGPLv3

### Maintainer
- Stefan Schulz (Einzelentwickler, KI-unterstützt)