#О Notebook
Notebook - API приложения, имитирующее записную книжку с функционалом, определенным в спецификации.

Спецификацией выступает файл api-description.yml формата OpenAPI 3.0.0

#Требования
1) PHP 8+
2) Composer 2.6+
3) Mysql 8+

#Установка
- Перейти в терминале в директорию проекта.
- Выполнить команду:

```sh
composer update  
```


###Если планируете только использовать:
- Описать .env, используя .env.example. Рекомендуемые параметры:
```sh
DB_CONNECTION=mysql
DB_HOST=db_two
DB_PORT=3306
DB_DATABASE=future_database
DB_USERNAME=root 
DB_PASSWORD=root (использовать этот пароль только для локальной разработки/тестирования/использования)
```
- Выполнить последовательно команды:
```sh
bash build.sh
bash start.sh
bash migrate.sh
```
API будет доступно по адресу http://localhost:81/api/v1
###Если планируете разрабатывать допонительный функционал:
- Создать базу данных в MySQL с названием future_database
- После чего описать .env, используя .env.example. Рекомендуемые параметры:
```sh
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=future_database
DB_USERNAME=root 
DB_PASSWORD=root (использовать этот пароль только для локальной разработки/тестирования/использования)
```

- Выполнить последовательно команды:
```sh
php artisan migrate --seed
php artisan serve
```
API будет доступно по адресу http://localhost:8000/api/v1

#Тестирование
###Внимание, тестирование предоставлено интеграционными тестами, которые могут нарушить целостность базы данных. Убедитесь, что запускаете тесты на тестовой базе данных.

Тестирование написано на фреймворке dredd.
Запустить тестирование можно командой:
```sh
dredd api-description.yml http://localhost:8000/api/v1 --language=vendor/bin/dredd-hooks-php --hookfiles=./tests/Integration/hooks.php
```
Интеграционное тестирование доступно только вне контейнеризации. (То есть, только в версии для разработки).

Также, в связи с тем, что интеграционные тесты влияют на состояние базы данных, то рекомендуется делать миграцию с сидированием каждый раз, когда один из тестов не проходит. Таким образом, возвращая базу данных в исходное положение, тесты гарантированно будут давать правильный результат. 
#Стек технологий, которые используются в проекте
- PHP 8+
- Composer 2.6+
- Laravel 10  
- Mysql 8+
- Docker
- Dredd
- Swagger/OpenAPI 3.0
