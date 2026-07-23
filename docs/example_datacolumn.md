DataColumn Example
=======================

Kartik `DataColumn` extension used by [`GridView`](example_gridview.md).

Adds DataTables-style sorting CSS classes on the header cell:

- `sorting` — sortable, not active
- `sorting_asc` / `sorting_desc` — current sort direction

Usually you do **not** instantiate it directly: `GridView` sets

```
'dataColumnClass' => \cinghie\adminlte\widgets\DataColumn::class
```

Override per column only if needed:

```
[
    'class' => \cinghie\adminlte\widgets\DataColumn::class,
    'attribute' => 'name',
]
```
