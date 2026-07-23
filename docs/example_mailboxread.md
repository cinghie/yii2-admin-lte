Mailbox Read Example
=======================

Renders an AdminLTE “read mail” box (subject, sender, body, attachments).

```
<?php use cinghie\adminlte\widgets\MailboxRead; ?>

<?= MailboxRead::widget([
    'userName' => 'Jane Doe',
    'userImage' => '@web/img/user.jpg',   // optional avatar URL
    'mailSubject' => 'Project update',
    'mailSender' => 'Jane Doe <jane@example.com>',
    'mailBody' => '<p>Hello,</p><p>Here is the update…</p>',
    'mailAttachments' => $attachments,   // see below
]) ?>
```

## Attachments

`mailAttachments` is an array of objects that implement (or expose):

- `getAttachmentTypeIcon()` — HTML/icon for file type
- `fileUrl` — download URL
- `filename` — display name
- `formatSize()` — human-readable size

Empty array = no attachment list.

## Demo markup

For a static AdminLTE demo layout (hardcoded sample content), call the widget’s `demo()` method from a custom subclass or temporary view helper if needed — production code should use `widget()` with real data.
