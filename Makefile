setup-docker:
	docker-compose up --build -d

start-docker:
	docker-compose start

stop-docker:
	docker-compose stop

docker-migrate:
	docker-compose exec app php artisan migrate

db-prepare:
	php artisan migrate:fresh --force

docker-connect-db:
	docker-compose exec pgsql psql -U postgres -d student-exam-book

sniff-cs-fixer:
	php vendor/bin/php-cs-fixer fix -vvv --dry-run --show-progress=dots

lint-cs-fixer:
	php vendor/bin/php-cs-fixer fix -vvv --show-progress=dots

start-phpstan:
	php vendor/bin/phpstan analyze --memory-limit=-1

test-artisan:
	php artisan test
