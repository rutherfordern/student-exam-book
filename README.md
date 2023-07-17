## Установка

1. Склонируйте проект, затем выполните установку.
```sh
make setup-docker
```
2. Запустите миграции
```sh
make docker-migrate
```

## Импорт студентов
В проекте уже есть три файла со списком студентов. По желанию можно добваить свои файлы или загрузить несколько готовых.
```sh
docker-compose exec app php artisan import:file storage/tmp/students.csv
docker-compose exec app php artisan import:file storage/tmp/students_new.csv
```

## Команды

### Средний бал по предмету
Если загружены готовые файлы со студентами, то средний бал по предмету можно посмотреть так:
```sh
docker-compose exec app php artisan avg:scores Физика
docker-compose exec app php artisan avg:scores 'Дискретная математика'
```
### Удаление студента
При удалении студента ФИО нужно указывать в кавычках.
```sh
docker-compose exec app php artisan expel:students 'Иванов Иван Иванович'
```
