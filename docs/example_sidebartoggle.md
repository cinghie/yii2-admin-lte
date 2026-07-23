Sidebar Toggle Example
=======================

Hamburger control for AdminLTE `push-menu` (collapse/expand sidebar).

```
<?php use cinghie\adminlte\widgets\SidebarToggle; ?>

<!-- typically inside .navbar / .main-header -->
<?= SidebarToggle::widget() ?>
```

Renders:

```html
<a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
    <span class="sr-only">Toggle navigation</span>
</a>
```

No configuration options. Requires AdminLTE JS (`pushMenu`) loaded via `AdminLTEAsset` / `AdminLTEMinifyAsset`.
