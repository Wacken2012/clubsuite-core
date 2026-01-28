# Security Policy

## Supported Versions

Only the latest major version of this app is supported.

| Version | Supported          |
| ------- | ------------------ |
| latest  | :white_check_mark: |
| < 1.0   | :x:                |

## Reporting a Vulnerability

If you find a security vulnerability, please do **not** open an issue.
Please report it responsibly to the maintainer or via the Nextcloud Security program.

## Permissions & Roles

This app adheres to the ClubSuite RBAC model:
- **Member**: Can view own data.
- **Board (Vorstand)**: Can view and edit all data within this module.
- **Admin**: Full system access.

## Logging & Auditing

All critical write operations (Create, Update, Delete) are logged to the Nextcloud technical log (`nextcloud.log`) with the prefix `[clubsuite-core]`.

## GDPR / Privacy

This app implements the Nextcloud Privacy Manager (`IPersonalDataProvider`).
- **Export**: Users can request a data export via Nextcloud settings.
- **Deletion**: When a user is deleted, their association with records in this app is anonymized or removed according to configuration.
