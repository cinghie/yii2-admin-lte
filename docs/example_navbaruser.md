Navbar User Example
=======================

User dropdown in the main navbar.

## Default Value

```
<?php use cinghie\adminlte\widgets\NavbarUser; ?>

<?= NavbarUser::widget() ?>
```

## Custom Value

```
<?php
use cinghie\adminlte\widgets\NavbarUser;
use yii\helpers\Url;
?>

<?= NavbarUser::widget([
    'username' => Yii::$app->user->identity->username,
    'userimg' => Yii::$app->user->identity->profile->getImageUrl(),
    'usercreated' => Yii::$app->user->identity->created_at,
    'userbody' => true,
    'userbodyname1' => Yii::t('user', 'Account'),
    'userbodylink1' => Url::to(['/user/settings/account']),
    'userbodyname2' => Yii::t('user', 'Profile'),
    'userbodylink2' => Url::to(['/user/settings/profile']),
    'userbodyname3' => Yii::t('user', 'Networks'),
    'userbodylink3' => Url::to(['/user/security/networks']),
    'userfooter' => true,
    'userfootername1' => Yii::t('user', 'Account'),
    'userfooterlink1' => Url::to(['/user/settings/account']),
    'userfootername2' => Yii::t('user', 'Profile'),
    'userfooterlink2' => Url::to(['/user/settings/profile']),
]) ?>
```

## Main properties

| Property | Role |
|----------|------|
| `username` / `userimg` / `usercreated` | Header of the dropdown |
| `userbody` | Show middle link row (3 slots) |
| `userbodyname1..3` / `userbodylink1..3` | Middle links |
| `userfooter` | Show footer actions |
| `userfootername1..2` / `userfooterlink1..2` | Footer links |

Typically placed inside `.navbar-custom-menu` → `.navbar-nav`.
