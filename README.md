## Установка

1. Склонируйте проект
2. Создайте и настройте файл ```.env``` по примеру ```.env.example```
3. Выполните установку.
```sh
make setup-docker
```
4. Запустите миграции
```sh
make docker-migrate
```

## Импорт студентов
В проекте уже есть несколько файлов со списком студентов. 
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
### Оценки по определенному предмету
```sh
docker-compose exec app php artisan scores Химия
```
### Таблица студентов с двумя и более двойками
```sh
docker-compose exec app php artisan student:explusion:list
```
### Удаление студента
При удалении студента ФИО нужно указывать в кавычках.
```sh
docker-compose exec app php artisan expel:students 'Иванов Иван Иванович'
```
