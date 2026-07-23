Timeline Example
=======================

Activity timeline for logger / commerce entities (AdminLTE timeline markup).

> Depends on `cinghie/yii2-commerce`, `cinghie/yii2-user-extended` and logger models.  
> Intended for apps that already use those packages (e.g. CorimaCRM).

```
<?php use cinghie\adminlte\widgets\Timeline; ?>

<?= Timeline::widget([
    'days' => $days,     // list of day rows, each with created_date
    'items' => $items,   // log entries matched by created_date
]) ?>
```

## Expected data shape

**`$days`** — iterable of rows/arrays with at least:

- `created_date` — date key shown as timeline label

**`$items`** — objects with (typical logger fields):

| Field | Role |
|-------|------|
| `created_date` | Match against day label |
| `created_time` | Time shown in item |
| `created_by` | User id → username / profile link |
| `action` | `create` / `update` / `delete` (color class) |
| `icon` | Font Awesome class |
| `entity_name` | Entity type label |
| `entity_model` | Model switch (`Accounts`, `Order`, `Product`, …) |
| `entity_id` / `entity_url` | Resolve link to record |
| `data` | Fallback text if record missing |

Actions map to CSS helpers: `color-create`, `color-update`, `color-delete`.

## Notes

- Resolves many commerce entity types in `timelineItem()` (accounts, orders, products, taxes, …).
- Ensure related CSS for `.color-create` / `.color-update` / `.color-delete` is loaded in your theme if customized.
