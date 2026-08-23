# Changelog — cinghie/yii2-admin-lte

All notable changes to this package are documented in this file.

Format based on [Keep a Changelog](https://keepachangelog.com/).

### Documentation rules

- `CHANGELOG.md` and `UPDATE.md` are written in English.
- Update both files in the same change set whenever code, configuration, assets, security behaviour, compatibility requirements, or public APIs change.
- `CHANGELOG.md` uses dated headings (`## YYYY-MM-DD`, newest first); do not use an `Unreleased` section.
- `UPDATE.md` keeps open priorities first, followed by processed items and dated history.
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
- `DateTimePicker` package defaults are now caller-overridable instead of unconditionally replacing configured values.
- `ColorPicker` validates configuration, preserves caller `maxlength`/`placeholder` options, accepts normalized 3/6 digit HEX values, ignores unsafe palette entries, and shares CSS/JavaScript/global handlers across multiple instances.
- FullCalendar assets include the locale bundle and Calendar documentation describes locale configuration.
- README now documents current PHP/CI compatibility, development dependency policy, reusable widgets, security behavior, tests, and links to maintenance documents.

### Fixed

- Fixed Composer resolution for the intentional Cinghie development-branch dependency chain.
- Fixed `yii2-animate` branch constraint after its development branch moved from `master` to `main`.
- Fixed Invoice email/PEC validation: complete addresses are validated without a hard-coded TLD list or partial truncation; malformed/control-character input is rendered as encoded text without `mailto:`.
- Fixed Invoice URL/action handling so unsafe schemes are not promoted to executable links/actions.
- Fixed Calendar JSON/URL/color handling and locale asset availability.
- Fixed reusable input-widget tests that depended on source-code string matching rather than behavior.

### Security

- Hardened Invoice email/PEC and URL/action trust boundaries.
- ColorPicker palette values are restricted to valid HEX colors before being used for visual presentation.
- Reusable widget labels/attributes continue through Yii HTML encoding/helpers.
- Calendar event URLs reject unsafe executable schemes and event data uses HTML-safe JSON serialization.

### Tests

- CI validates Composer metadata, dependency resolution and PHPUnit on PHP 8.1–8.5.
- Added regression coverage for Invoice malformed email/control-character input and modern TLDs.
- Added Calendar, Carousel/Accordion and reusable input-widget behavioral/security tests.
- Reusable input-widget tests cover defaults/overrides, invalid configuration, malicious palette entries, label encoding, custom HTML options and shared asset registration.

## 2026-08-22

### Added

- Added AdminLTE 2 Calendar widget integration with FullCalendar 3, dedicated runtime/print assets, Yii route URL normalization and optional draggable external events.
- Added Bootstrap 3 Carousel and Accordion widgets with AdminLTE-compatible markup and safe content defaults.
- Added documentation and tests for Calendar, Carousel and Accordion.

### Changed

- Expanded widget smoke/best-practice coverage and hardened the PHP test harness for cross-version session behavior.

### Fixed

- Fixed PHP 8.0 test-session initialization by using a fully in-memory test session with no native session INI side effects.
- Fixed Calendar tests to assert JSON-safe URL serialization and Bootstrap-rendered class semantics rather than brittle raw strings.

### Security

- Added encoding and input-hardening coverage for Carousel/Accordion content, captions, controls, labels and footers.
- Calendar normalizes URLs/colors and safely serializes event data.
