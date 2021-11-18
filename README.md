Simple snowflake for laravel.

# QUIKE START

## INSTALL

`composer install imdgr886/snowflake`

## USAGE

```php
use Imdgr886\Snowflake\Facades\Snowflake;

//...

Snowflake::id();
```

## Custom

```shell
php artisan vendor:publish --tag=snowflake
```

then edit `config/snowflake.php`