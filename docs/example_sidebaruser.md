Sidebar User Example
=======================

User panel at the top of the sidebar.

## Default Value

```
<?php use cinghie\adminlte\widgets\SidebarUser; ?>

<?= SidebarUser::widget() ?>
```

## Custom Value

```
<?php use cinghie\adminlte\widgets\SidebarUser; ?>

<?= SidebarUser::widget([
    'username' => Yii::$app->user->identity->username,
    'userimg' => Yii::$app->user->identity->profile->getAvatarUrl(),
]) ?>
```

| Property | Default |
|----------|---------|
| `username` | `Your Username` |
| `userimg` | placeholder avatar URL |

Status line is hardcoded as “Online”.
