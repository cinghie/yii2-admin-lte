# Changelog — cinghie/yii2-admin-lte

All notable changes to this package are documented in this file starting from release **1.6.0**.

Format based on [Keep a Changelog](https://keepachangelog.com/).

### Documentation rules

- `CHANGELOG.md` and `UPDATE.md` are written in English.
- Update both files in the same change set whenever code, configuration, assets, security behaviour, compatibility requirements, tests, or public APIs change.
- `CHANGELOG.md` starts from the `1.6.0` release baseline and records only changes made after that release plus the baseline itself.
- Post-release changes use dated headings (`## YYYY-MM-DD`, newest first); do not use an `Unreleased` section.
- Public documentation must not contain credentials, private hosts, customer data, internal project names, private paths, exploit recipes, or references to non-public systems.

---

## 2026-08-23

### Added

- Added reusable AdminLTE 2 / Bootstrap 3 `ColorPicker`, `DatePicker`, and `DateTimePicker` input widgets.
- Added dedicated documentation for the three reusable input widgets.
- Added behavioral/configuration/security regression coverage for reusable input widgets.
- Added MIT `LICENSE` file aligned with the Cinghie AdminLTE package family.
- Added root `CHANGELOG.md` and `UPDATE.md` maintenance documents.

### Changed

- Raised the development-branch PHP requirement to PHP 8.1+ and updated CI to PHP 8.1, 8.2, 8.3, 8.4 and 8.5.
- Cinghie dependencies intentionally track their active development branches: `yii2-animate` uses `dev-main`; `yii2-fontawesome` and `yii2-traits` use `dev-master`.
- Composer now uses `minimum-stability: dev` with `prefer-stable: true` so explicit development dependencies resolve while unrelated dependencies still prefer stable releases.
- `DateTimePicker` package defaults are caller-overridable instead of unconditionally replacing configured values.
- `ColorPicker` validates configuration, preserves caller `maxlength` / `placeholder` options, normalizes valid HEX values, ignores unsafe palette entries, and shares CSS/JavaScript/global handlers across multiple instances.
- README now documents current PHP/CI compatibility, development dependency policy, reusable widgets, test coverage, maintenance documents, and MIT licensing.

### Fixed

- Fixed Composer resolution for the intentional Cinghie development-branch dependency chain.
- Fixed `yii2-animate` branch constraint after its active development branch moved from `master` to `main`.
- Fixed reusable input-widget tests that depended on source-code string matching rather than behavior.

### Security

- ColorPicker palette values are constrained to valid HEX values before being used for visual presentation.
- Reusable widget labels and HTML attributes continue through Yii encoding/helpers.

### Tests

- CI validates Composer metadata, dependency resolution, and PHPUnit on PHP 8.1–8.5.
- Reusable input-widget tests cover defaults/overrides, invalid configuration, malicious palette entries, label encoding, custom HTML options, multi-instance rendering, and shared asset registration.

## 2026-08-22

### Changed

- FullCalendar assets now include the locale bundle and Calendar documentation describes locale configuration.
- The active CI matrix moved from PHP 8.0–8.4 to PHP 8.1–8.5.
- Composer dependency policy was changed so Cinghie packages intentionally follow active development branches while unrelated packages still prefer stable releases.

### Fixed

- Fixed Composer dependency resolution for the chosen development-branch policy.
- Fixed the `yii2-animate` constraint to `dev-main` while `yii2-fontawesome` and `yii2-traits` remain on `dev-master`.

### Tests

- Verified the Composer dependency graph and PHPUnit suite on PHP 8.1, 8.2, 8.3, 8.4, and 8.5.

## 1.6.0 — 2026-08-18

Release baseline. Tag `1.6.0` points to commit `db5c6fab07df9beae96d9e66870068d019205152` (`Add Invoice email validation regressions`).

### Added

- Added the AdminLTE 2 Calendar widget with FullCalendar 3 integration, dedicated runtime/print assets, Yii route URL normalization, locale-ready client configuration, and optional draggable external events.
- Added Bootstrap 3 Carousel and Accordion widgets with AdminLTE-compatible markup, contextual panels, safe encoding defaults, documentation, and regression tests.
- Added a GitHub Actions PHPUnit matrix and cross-version Yii test harness.

### Changed

- Added explicit `yiisoft/yii2-bootstrap` runtime dependency and modernized the Composer/test setup.
- Expanded widget smoke and best-practice coverage.

### Fixed

- Stabilized the test harness with a fully in-memory session so PHPUnit runs cleanly across supported PHP versions.
- Fixed Calendar URL/JSON/color validation and print asset issues discovered during CI bring-up.
- Fixed Invoice email validation so complete addresses are validated without a hard-coded TLD whitelist or partial truncation.

### Security

- Calendar event URLs reject unsafe executable schemes and event data uses HTML-safe JSON serialization.
- Carousel and Accordion encode untrusted content, captions, controls, labels, list entries, and footers by default.
- Invalid or contaminated Invoice email/PEC values are rendered as encoded plain text and do not receive `mailto:` links.

### Tests

- Added regression coverage for Calendar, Carousel/Accordion, Invoice email validation, widget smoke tests, and Yii2 best-practice contracts.
- Release 1.6.0 was cut from the commit that includes the final Invoice email-validation regressions.
