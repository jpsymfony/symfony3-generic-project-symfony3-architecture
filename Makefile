build_docker: init build up

init:
	cp app/config/parameters.yml.dist app/config/parameters.yml

build:
	docker-compose build --build-arg USER=${USER} --build-arg UID=${UID} php_70

up:
	docker-compose up -d

ssh:
	docker exec -it php_70 bash

install:
	docker exec -u=${USER} -i php_70 bash -c 'make composer'
	docker exec -u=${USER} -i php_70 bash -c 'make setfacl'
	docker exec -u=${USER} -i php_70 bash -c 'make assetic'
	docker exec -u=${USER} -i php_70 bash -c 'make database'

composer:
	curl -sS https://getcomposer.org/installer | php -- --install-dir=bin --filename=composer
	chmod +x bin/composer || /bin/true
	./bin/composer self-update
	./bin/composer install --no-interaction -o

setfacl:
	setfacl -dR -m u:"www-data":rwX -m u:$(whoami):rwX var
	setfacl -R -m u:"www-data":rwX -m u:$(whoami):rwX var

assetic:
	php bin/console assetic:dump

database:
	php bin/console doctrine:database:create && php bin/console doctrine:schema:create && php bin/console doctrine:fixtures:load -n

stop:
	docker-compose stop

cache:
	docker exec -u=${USER} -i php_70 bash -c 'bin/console cache:clear --no-warmup && bin/console cache:warmup'
