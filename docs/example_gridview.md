GridView Example
=======================

Kartik GridView styled as an AdminLTE 2 `box`, with DataTables-like table classes and pager wrapper.

Requires `kartik-v/yii2-grid`.

```
<?php use cinghie\adminlte\widgets\GridView; ?>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'boxClass' => 'box-primary',   // extra classes on outer .box
    'columns' => [
        'id',
        'name',
        'created',
        ['class' => 'yii\grid\ActionColumn'],
    ],
]) ?>
```

## Defaults (vs Kartik)

| Property | Default |
|----------|---------|
| `dataColumnClass` | `cinghie\adminlte\widgets\DataColumn` |
| `tableOptions` | `['class' => 'table dataTable']` |
| `bordered` / `condensed` / `striped` / `hover` | `true` |
| `responsive` / `responsiveWrap` | `true` |
| `pjax` | `true` |
| `layout` | box-body items + box-footer summary/pager |

Related: [DataColumn](example_datacolumn.md), [Box](example_box.md) (lighter grid-in-box for dashboards).
