# Release Vorbereitung Checkliste

## Vor jedem Release
- [ ] Version in `appinfo/info.xml` erhöhen.
- [ ] `CHANGELOG.md` aktualisieren.
- [ ] Tests lokal ausführen: `npm run build`.
- [ ] Dokumentation prüfen.

## Tagging
`git tag -a v0.1.0 -m "Release version 0.1.0"`
`git push origin v0.1.0`

## Signierung
Nutze das Nextcloud `codesigning` Tool für produktive Releases.

## Store-Upload
1. Erzeuge das Archiv über den Release-Workflow.
2. Lade das Archiv im Nextcloud App Store hoch (apps.nextcloud.com).
