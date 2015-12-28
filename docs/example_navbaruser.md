Navbar User Example
=======================

## Default Value

```
<?php use cinghie\adminlte\widgets\NavbarUser; ?>

<!-- navbar user -->
<?= NavbarButton::widget() ?>
```

## Custom Value

```
<?php use cinghie\adminlte\widgets\NavbarUser; ?>

<!-- navbar user -->
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
    'userfooterlink2' => Url::to(['/user/settings/profile'])
]) ?>
```
