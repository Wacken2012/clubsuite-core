# Contributing

Thank you for considering contributing to ClubSuite!

## Pull Requests
1. Fork the repository.
2. Create a feature branch (`feature/my-new-feature`).
3. Commit your changes. Please adhere to [Conventional Commits](https://www.conventionalcommits.org/).
4. Push to the branch.
5. Create a new Pull Request.

## Coding Standards
We follow the strict Nextcloud coding standards.
- **PHP**: Check with `php-cs-fixer`.
- **JS/Vue**: Check with `eslint`.

## Testing
Please run unit tests before submitting:
```bash
./vendor/bin/phpunit
```

## Development Setup
1. Clone into `apps/clubsuite-core`.
2. Enable with `occ app:enable clubsuite-core`.
3. Install dependencies: `composer install` / `npm install`.
4. Build frontend: `npm run build`.
