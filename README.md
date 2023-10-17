<h1 style="text-align: center;">Импорт базы ГАР в Laravel 10</h1>

## Решаемая задача

Загрузить и свести данные об идентификаторе ФИАС, городе, улице и номере дома для отдельно взятого 
региона в табличную форму с использованием представления базы данных

## О приложении

Консольное приложение
- загружает свежую полную выгрузку с сервера ГАР в файловое хранилище
- извлекает данные требуемого региона
- парсит XML файлы с выгрузкой и заносит данные в таблицы
- реализует многопоточность с использованием фасада Process
- представляет данные в удобном табличном виде, используя представление базы данных

Не требует web-сервера и запущенных воркеров Laravel.

Реализована «актуализация» неактивных данных

## Требования к системе

PHP не ниже 8.1, утилита wget (существует версия для Windows), соединение с базой данных.
Если путь к wget не прописан в PATH, следует прописать путь к утилите в 
конфигурационном файле config/gar.php.

## Установка приложения

Клонируйте приложение или скачайте его архивом

```shell
git clone git@github.com:IggorGor/gar.git
```

Перейдите в каталог с приложением и настройте права на каталоги
```shell
cd gar
sudo chown -R $USER:www-data storage
sudo chown -R $USER:www-data bootstrap/cache
chmod -R 775 storage
chmod -R 775 bootstrap/cache
```

Настройте **.env** и **config/gar.php**. Если ваша база не PostgreSQL, имя базы данных 
обязательно должно быть **gar**. В конфигурационном файле настройте 
номер своего региона и пути. Настройте таймауты и параметр **retry_after** в файле
**config/queue.php**. Для использования многопоточности драйвер очереди должен
отличаться от **sync**

Установите зависимости

```shell
composer install --no-dev --optimize-autoloader
```

Выполните миграции

```shell
php artisan migrate
```

## Запуск приложения

Выполните команду

```shell
php artisan gar:complete-full-import
```

Дождитесь её выполнения. Время зависит от производительности вашей системы и скорости
Интернета.

Воспользуйтесь представлением **gar.gar.gar_data_by_uuid** для доступа к данным

```postgresql
select * from gar.gar_data_by_uuid
where city_name = 'Ново-Талицы'
and street_name = '5-я Изумрудная'
```
Или воспользуйтесь моделью **Models\Gar\GarDataByUUID**

```php
$result = GarDataByUUID::where('house_object_guid', '=',
    '5cef293c-745f-4053-bed6-05466f2758f4')->first();
```

Если что-то не заработало или испытываете проблемы с производительностью, прочитайте 
[статью на habr](https://habr.com/ru/articles/764392/) с описанием приложения

## Дополнительные команды

- **gar:full-download** — скачивает выгрузку в файловое хранилище
- **gar:full-extract** — извлекает необходимые файлы из выгрузки
- **gar:full-import** — ставит задания на парсинг xml и запись данных в БД
- **gar:start-workers** — запускает обработчики очереди Laravel

## «Актуализация» неактуальных данных
### Откуда берутся неактуальные данные?
Бывает, что компании и юр. лица, которым принадлежат дома, не озабочены 
актуализацией информации. Если информация не актуализирована, ГАР помечает дома, 
как неактивные, но информация всё равно доступна в справочнике. Чтобы работать 
с такими домами приходится их "актуализировать".

### Как понять, что информация о доме неактуальна?

Поле **house_active** равно ```false```, а все поля, кроме, 
house_object_id и house_object_guid содержат ```null```.

### Как актуализировать информацию о доме?

Теоретические аспекты актуализации изложены в [статье на habr](https://habr.com/ru/articles/763828#actualization). 

На практике нужно вызвать метод, принимающий UUID неактивного дома

```php
GarService::activateHouse('5cef293c-745f-4053-bed6-05466f2758f4');
```

**Важно!** Этот метод работает только для полной выгрузки. При выгрузке дельт этот метод приведёт к коллизиям.
