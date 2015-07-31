
В composer.json добавляем в блок require
```json
 "vis/rating": "1.0.*"
```

Выполняем
```json
composer update
```

Добавляем в app.php
```php
  'Vis\Rating\RatingServiceProvider',
```

Выполняем миграцию таблиц
```json
   php artisan migrate --package=vis/rating
```

Публикуем js файлы
```json
   php artisan asset:publish vis/rating
```
-----------------------------------
Использование на фронтенде:

Подключаем в футере js файл
```json
<script src="{{asset('packages/vis/rating/rating.js')}}"></script>
```json

Код на странице для голосования
```php
{{Rating::showVote($page)}}
```

Код на странице для просмотра рейтинга статьи
```php
{{Rating::showResult($page)}}
```