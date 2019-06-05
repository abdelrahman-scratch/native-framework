BIN_DOCKER = 'docker'
BIN_DOCKER_COMPOSE = 'docker-compose'


CONTAINER_NGINX = check24_nginx
CONTAINER_PHP72 = check24_php72
CONTAINER_MYSQL = check24_mysql

clear_all: clear_containers clear_images

clear_containers:
	$(BIN_DOCKER) stop `$(BIN_DOCKER) ps -a -q` && $(BIN_DOCKER) rm `$(BIN_DOCKER) ps -a -q`

stop_all_containers:
	$(BIN_DOCKER) stop `$(BIN_DOCKER) ps -a -q`

clear_images:
	$(BIN_DOCKER) rmi -f `$(BIN_DOCKER) images -q`

up_background:
	$(BIN_DOCKER_COMPOSE) up -d

build:
	$(BIN_DOCKER_COMPOSE) build

up:
	$(BIN_DOCKER_COMPOSE) up

host:
	sh ./update-hosts.sh

phpunit_test:
	$(BIN_DOCKER_COMPOSE) exec $(CONTAINER_PHP72) ./vendor/bin/phpunit

cp_env:
	cp .env.example .env

down:
	$(BIN_DOCKER_COMPOSE)  stop

logs_nginx:
	$(BIN_DOCKER) logs -t -f $(CONTAINER_NGINX)

php_composer_install:
	$(BIN_DOCKER_COMPOSE) exec $(CONTAINER_PHP72) composer install

init: up_background php_composer_install
