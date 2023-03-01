# Monolog Dio Handler

```bash
composer require ziffmedia/monolog-dio-handler
```

This extension is useful primarily when using the dio extension so that you can write to a
linux kernel pipe like `/proc/1/fd/1`.  PHP's file IO operations cannot natively open this kind
of file without issue.