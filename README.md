Simple snowflake for laravel. Support at least 200 years.


This library removed **Worker ID**. Instead, use redis process sequence index.

default requements:

-   `redis`

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
