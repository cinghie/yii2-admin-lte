# yii2-admin-lte — UPDATE roadmap

Maintenance, stabilization, and evolution notes for the public Yii2 AdminLTE 2 package.

### Documentation rules

- `CHANGELOG.md` and `UPDATE.md` are written in English and updated together when code, configuration, assets, security behaviour, compatibility requirements, tests, or public APIs change.
- `CHANGELOG.md` uses dated headings, newest first; no `Unreleased` section.
- `UPDATE.md` keeps open priorities first, then processed work and dated history.
- Public documentation must not contain credentials, private hosts, customer data, internal project names, private paths, exploit recipes, or references to non-public systems.

Urgency: **Critical** · **High** · **Medium** · **Low**.

---

## Priority list

| Urgency | Item | Why | Recommended action |
|---------|------|-----|--------------------|
| **High** | Refactor legacy `Timeline` widget | The historical implementation is application/domain coupled, performs model/database lookups inside presentation code and mixes routing/business logic with HTML generation. | Replace it with a presentation-only AdminLTE timeline that receives prepared items, encodes untrusted values by default, performs no DB queries and has dedicated tests/docs before closing issue #6. |
| **Low** | Real-browser smoke for interactive widgets | PHPUnit validates server-rendered markup/configuration but cannot prove all third-party Bootstrap/FullCalendar interactions in a browser. | Include representative Calendar, Carousel/Accordion and date/time picker interaction smoke checks in release validation or a host application. |

---

## Open — Security & safe rendering

No known Critical/High security defect remains from the 2026-08-22/23 hardening passes. Keep URL schemes, raw HTML, CSS values, email links and JSON-backed client configuration as explicit trust boundaries. Preserve the Invoice, Calendar, Carousel/Accordion and input-widget security regressions in CI.

---

## Open — Correctness & architecture

The main architectural debt is `Timeline` (issue #6). It should become a generic presentation widget and must not depend on Commerce/UserExtended models or execute persistence lookups. Calendar, Carousel, Accordion, Invoice and reusable input widgets should remain feature-module independent.

---

## Open — Performance

No known medium-or-higher performance issue remains from the current pass. ColorPicker now shares CSS/JavaScript and document-level handlers across instances. Calendar-specific assets remain separate from the main AdminLTE bundle so non-calendar pages do not pay that cost.

---

## Open — Tests, QA & compatibility

The active development branch requires PHP 8.1+ and CI covers PHP 8.1–8.5. Keep `composer validate --strict`, dependency installation and PHPUnit blocking. Prefer behavioral rendering/configuration tests over source-code string matching. When Cinghie development branches or third-party assets move, verify the complete dependency graph on every supported PHP version.

---

## Open — Documentation, packaging & release hygiene

Keep `README.md`, `CHANGELOG.md`, `UPDATE.md`, widget examples, Composer compatibility notes and release notes synchronized. Cinghie dependencies intentionally follow active development branches (`dev-main`/`dev-master`) while Composer uses `minimum-stability: dev` and `prefer-stable: true`.

---

## Processed — 2026-08-23 input widgets, dependency policy and hardening

| Item | Result |
|------|--------|
| PHP support | Development branch moved to PHP 8.1+; CI matrix is PHP 8.1–8.5. |
| Cinghie dependency policy | `yii2-animate` tracks `dev-main`; `yii2-fontawesome` and `yii2-traits` track `dev-master`; Composer permits explicit dev constraints while preferring stable packages otherwise. |
| Reusable inputs | Added package-owned ColorPicker, DatePicker and DateTimePicker for AdminLTE 2 / Bootstrap 3 consumers. |
| Date/time defaults | Package defaults remain overridable by normal Yii widget configuration. |
| ColorPicker safety | Palette/configuration is validated, HEX values normalized, unsafe entries ignored, caller input options preserved and shared client code registered once per page. |
| Invoice email/PEC | Removed hard-coded TLD handling and partial-address recovery; only complete valid addresses receive `mailto:` links, malformed values remain encoded text. |
| Invoice actions/URLs | Unsafe executable URL schemes are not promoted to actions/links. |
| Calendar locale support | FullCalendar locale bundle is registered and documented. |
| Tests | Added behavior/security regressions for input widgets and Invoice; retained Calendar, Carousel/Accordion and existing widget coverage. |
| Documentation | Added dedicated input-widget guides and refreshed README, Calendar and Invoice documentation. |
| Licensing | Added standard MIT license file consistent with the Cinghie AdminLTE package family. |

---

## Processed — 2026-08-22 Calendar, Carousel/Accordion and test stabilization

| Item | Result |
|------|--------|
| Calendar | Added FullCalendar 3 widget, dedicated/print assets, Yii route normalization, event/color hardening and optional AdminLTE draggable-event UI. |
| Carousel / Accordion | Added Bootstrap 3 wrappers with safe encoding defaults, explicit trusted-HTML opt-ins and contextual panel support. |
| Cross-version tests | Stabilized the test session as a fully in-memory implementation and removed native PHP session side effects. |
| CI | Widget suite was brought green across the then-supported PHP matrix before the later move to PHP 8.1–8.5. |
| Documentation | Added Calendar, Carousel and Accordion examples and updated README coverage. |

---

## Possible future expansions

- Complete issue #6 with a generic Timeline widget and migration example from the historical domain-coupled API.
- Consider extracting additional optional plugin assets only when measurement shows a meaningful page-weight benefit without breaking AdminLTE 2 compatibility.
- Add browser-level interaction smoke coverage for the most JavaScript-heavy widgets while keeping PHPUnit as the fast blocking package suite.

---

## History

### 2026-08-23

- Standardized PHP 8.1–8.5 CI and intentional development-branch dependency resolution.
- Added and hardened reusable input widgets.
- Hardened Invoice email/PEC and URL behavior.
- Added FullCalendar locale support and refreshed public documentation.
- Added MIT licensing plus CHANGELOG/UPDATE maintenance discipline.

### 2026-08-22

- Added Calendar, Carousel and Accordion widgets with tests/documentation.
- Stabilized the cross-version Yii test harness and session behavior.
