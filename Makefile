#SANS DOCKER:
build: install init

install:
	cp app/config/parameters.yml.dist app/config/parameters.yml
	./bin/console assetic:dump

init:
	php bin/console doctrine:database:create
	php bin/console doctrine:schema:create
	php bin/console doctrine:fixtures:load -n
	php bin/console server:start


#AVEC DOCKER:
build_docker: up init_docker ssh

up:
	docker-compose up -d

init_docker:
	docker exec -i php_70 bash -c 'php bin/console doctrine:database:create && php bin/console doctrine:schema:create && php bin/console doctrine:fixtures:load -n'

rebuild:
	docker-compose build --no-cache

ssh:
	docker exec -it php_70 bash

stop:
	docker-compose stop

cache:
	docker exec -i php_70 bash -c 'bin/console cache:clear --no-warmup && bin/console cache:warmup && chmod -R 777 var/cache var/logs var/sessions'
