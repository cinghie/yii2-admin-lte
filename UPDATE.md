# yii2-admin-lte — UPDATE roadmap

Maintenance, stabilization, and evolution notes for the public Yii2 AdminLTE 2 package, using release **1.6.0** as the historical baseline.

### Documentation rules

- `CHANGELOG.md` and `UPDATE.md` are written in English and updated together when code, configuration, assets, security behaviour, compatibility requirements, tests, or public APIs change.
- `CHANGELOG.md` starts from release `1.6.0` and records only that baseline plus subsequent changes.
- `UPDATE.md` keeps open priorities first, then processed work after `1.6.0`, followed by the release baseline and dated history.
- Public documentation must not contain credentials, private hosts, customer data, internal project names, private paths, exploit recipes, or references to non-public systems.

Urgency: **Critical** · **High** · **Medium** · **Low**.

---

## Baseline

Release **1.6.0** is the reference point for this roadmap.

- Tag: `1.6.0`
- Release commit: `db5c6fab07df9beae96d9e66870068d019205152`
- Commit message: `Add Invoice email validation regressions`
- Release date: 2026-08-18

Everything below the open-priority sections describes work performed **after** that release unless explicitly marked as part of the 1.6.0 baseline.

---

## Priority list

| Urgency | Item | Why | Recommended action |
|---------|------|-----|--------------------|
| **High** | Refactor legacy `Timeline` widget | The historical implementation is application/domain coupled, performs model/database lookups inside presentation code, and mixes routing/business logic with HTML generation. | Replace it with a presentation-only AdminLTE timeline that receives prepared items, encodes untrusted values by default, performs no DB queries, and has dedicated tests/docs before closing issue #6. |
| **Low** | Real-browser smoke for interactive widgets | PHPUnit validates server-rendered markup/configuration but cannot prove all third-party Bootstrap/FullCalendar interactions in a browser. | Include representative Calendar, Carousel/Accordion and date/time picker interaction smoke checks in release validation or a host application. |

---

## Open — Security & safe rendering

No known Critical/High security defect remains from the post-1.6.0 hardening passes. Keep URL schemes, raw HTML, CSS values, email links, and JSON-backed client configuration as explicit trust boundaries. Preserve the Invoice, Calendar, Carousel/Accordion, and reusable input-widget security regressions in CI.

---

## Open — Correctness & architecture

The main architectural debt is `Timeline` (issue #6). It should become a generic presentation widget and must not depend on Commerce/UserExtended models or execute persistence lookups. Calendar, Carousel, Accordion, Invoice, and reusable input widgets should remain feature-module independent.

---

## Open — Performance

No known medium-or-higher performance issue remains from the current post-1.6.0 pass. ColorPicker shares CSS/JavaScript and document-level handlers across instances. Calendar-specific assets remain separate from the main AdminLTE bundle so pages without Calendar do not pay that cost.

---

## Open — Tests, QA & compatibility

The active development branch requires PHP 8.1+ and CI covers PHP 8.1–8.5. Keep `composer validate --strict`, dependency installation, and PHPUnit blocking. Prefer behavioral rendering/configuration tests over source-code string matching. When Cinghie development branches or third-party assets move, verify the complete dependency graph on every supported PHP version.

---

## Open — Documentation, packaging & release hygiene

Keep `README.md`, `CHANGELOG.md`, `UPDATE.md`, widget examples, Composer compatibility notes, and release notes synchronized. Cinghie dependencies intentionally follow active development branches (`dev-main` / `dev-master`) while Composer uses `minimum-stability: dev` and `prefer-stable: true`.

---

## Processed — 2026-08-23 reusable input widgets, documentation, and hardening

| Item | Result |
|------|--------|
| Reusable inputs | Added package-owned ColorPicker, DatePicker, and DateTimePicker for AdminLTE 2 / Bootstrap 3 consumers. |
| Date/time defaults | Package defaults remain overridable by normal Yii widget configuration. |
| ColorPicker validation | Palette/configuration is validated, valid HEX values normalized, unsafe entries ignored, and caller input options preserved. |
| ColorPicker performance | Shared CSS/JavaScript and document-level listeners are registered once per page rather than once per instance. |
| Input-widget tests | Replaced source-grep assertions with behavioral/configuration/security regressions. |
| Input-widget docs | Added dedicated ColorPicker, DatePicker, and DateTimePicker guides and linked them from README. |
| Calendar docs | Documented FullCalendar locale support and the existing event ownership/hardening contract. |
| Invoice docs | Documented the 1.6.0 email/PEC hardening baseline and URL/action safety behavior. |
| Licensing | Added the standard MIT license used by the Cinghie AdminLTE package family. |
| Maintenance docs | Added root CHANGELOG/UPDATE navigation and maintenance discipline. |

---

## Processed — 2026-08-22 dependency policy, PHP matrix, and locale support

| Item | Result |
|------|--------|
| PHP support | Development branch moved from the 1.6.0-era PHP 8.0–8.4 matrix to PHP 8.1–8.5. |
| Cinghie dependency policy | `yii2-animate` tracks `dev-main`; `yii2-fontawesome` and `yii2-traits` track `dev-master`. |
| Composer stability | Added `minimum-stability: dev` plus `prefer-stable: true` so explicit Cinghie development branches resolve without forcing unrelated dependencies onto dev versions. |
| Branch correction | Fixed `yii2-animate` from the invalid `dev-master` constraint to its real development branch `dev-main`. |
| Calendar locale support | Added the FullCalendar locale bundle and documented client-side locale configuration. |
| CI verification | Composer validation, dependency resolution, and PHPUnit were verified green on PHP 8.1–8.5 after the dependency-policy changes. |

---

## Release baseline — 1.6.0 (2026-08-18)

Release 1.6.0 already contained the major stabilization work completed before the tag:

| Area | 1.6.0 baseline |
|------|----------------|
| Calendar | AdminLTE 2 FullCalendar 3 widget, dedicated/print assets, Yii route normalization, URL/color hardening, optional draggable-event UI, tests, and documentation. |
| Carousel / Accordion | Bootstrap 3 wrappers with safe encoding defaults, trusted-HTML opt-ins, contextual panel support, tests, and documentation. |
| Invoice | Hardened rendering plus complete email validation without hard-coded TLD truncation; malformed email/PEC values remain encoded text rather than becoming `mailto:` links. |
| Test harness | Cross-version in-memory session implementation with no native PHP session INI side effects. |
| CI | GitHub Actions matrix, Composer validation, Asset Packagist setup, Yii Composer plugin authorization, dependency installation, and PHPUnit. |
| Composer | Explicit Yii2 Bootstrap runtime dependency and cleaned dependency/test setup. |

The baseline commit is `db5c6fab07df9beae96d9e66870068d019205152`; earlier implementation micro-commits are intentionally not reproduced as separate roadmap history because `1.6.0` is the chosen starting point.

---

## Possible future expansions

- Complete issue #6 with a generic Timeline widget and migration example from the historical domain-coupled API.
- Consider extracting additional optional plugin assets only when measurement shows a meaningful page-weight benefit without breaking AdminLTE 2 compatibility.
- Add browser-level interaction smoke coverage for the most JavaScript-heavy widgets while keeping PHPUnit as the fast blocking package suite.

---

## History

### 2026-08-23

- Added and hardened reusable input widgets.
- Replaced brittle source-text tests with behavioral/configuration/security coverage.
- Refreshed README and dedicated widget documentation.
- Added MIT licensing and synchronized maintenance documentation.
- Rebased CHANGELOG/UPDATE history on the 1.6.0 release commit.

### 2026-08-22

- Moved the development CI target to PHP 8.1–8.5.
- Adopted the intentional Cinghie dev-branch Composer policy with stable preference for unrelated packages.
- Corrected `yii2-animate` to `dev-main`.
- Added FullCalendar locale bundle support.

### 2026-08-18 — 1.6.0

- Release baseline at `db5c6fab07df9beae96d9e66870068d019205152`.
