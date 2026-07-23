Sidebar Menu Example
=======================

Nested sidebar menu (AdminLTE treeview). Compatible with typical Yii menu `items` structure.

```
<?php use cinghie\adminlte\widgets\SidebarMenu; ?>

<?= SidebarMenu::widget([
    'items' => [
        ['label' => 'Menu Yii2', 'options' => ['class' => 'header']],
        ['label' => 'Gii', 'icon' => 'fa fa-file-code-o', 'url' => ['/gii']],
        ['label' => 'Debug', 'icon' => 'fa fa-dashboard', 'url' => ['/debug']],
        [
            'label' => 'Login',
            'url' => ['site/login'],
            'visible' => Yii::$app->user->isGuest,
        ],
        [
            'label' => 'Same tools',
            'icon' => 'fa fa-share',
            'url' => '#',
            'items' => [
                ['label' => 'Gii', 'icon' => 'fa fa-file-code-o', 'url' => ['/gii']],
                ['label' => 'Debug', 'icon' => 'fa fa-dashboard', 'url' => ['/debug']],
                [
                    'label' => 'Level One',
                    'icon' => 'fa fa-circle-o',
                    'url' => '#',
                    'items' => [
                        ['label' => 'Level Two', 'icon' => 'fa fa-circle-o', 'url' => '#'],
                        [
                            'label' => 'Level Two',
                            'icon' => 'fa fa-circle-o',
                            'url' => '#',
                            'items' => [
                                ['label' => 'Level Three', 'icon' => 'fa fa-circle-o', 'url' => '#'],
                                ['label' => 'Level Three', 'icon' => 'fa fa-circle-o', 'url' => '#'],
                            ],
                        ],
                    ],
                ],
            ],
        ],
    ],
]) ?>
```

## Item keys

| Key | Description |
|-----|-------------|
| `label` | Menu text |
| `icon` | Font Awesome class (e.g. `fa fa-dashboard`) |
| `url` | Route array or string |
| `items` | Nested children (treeview) |
| `visible` | Conditionally show item |
| `options` | HTML options (e.g. header row) |

Place after `SidebarUser` / `SidebarSearch` inside `.sidebar`.
