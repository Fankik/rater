.DEFAULT_GOAL := help

CURRENT_DIR = $(dir $(abspath $(firstword $(MAKEFILE_LIST))))
DOCKER_FOLDER = $(CURRENT_DIR)/docker
DOCKER_COMPOSE_DEFAULT_FILE = $(DOCKER_FOLDER)/docker-compose.yaml
DOCKER_COMPOSE_OVERRIDE_FILE = $(DOCKER_FOLDER)/docker-compose.override.yaml

DB_CONTAINER_NAME = database
PHP_CONTAINER_NAME = php
NODE_CONTAINER_NAME = node

ifneq ("$(wildcard $(DOCKER_COMPOSE_OVERRIDE_FILE))","")
    docker_compose_files = -f $(DOCKER_COMPOSE_DEFAULT_FILE) -f $(DOCKER_COMPOSE_OVERRIDE_FILE)
else
    docker_compose_files = -f $(DOCKER_COMPOSE_DEFAULT_FILE)
endif

ifneq (, $(which docker-compose))
    $(info ************ DOCKER ************)
    $(info Use `docker compose`. See https://docs.docker.com/compose/install/linux)
    $(info ********************************)
    docker-compose-relative := docker-compose --project-directory $(DOCKER_FOLDER) $(docker_compose_files)
else
    docker-compose-relative := docker compose --project-directory $(DOCKER_FOLDER) $(docker_compose_files)
endif

help:
	@grep -E '^[a-zA-Z_\.-]+:.*?## .*$$' $(MAKEFILE_LIST) | sort | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[36m%-38s\033[0m %s\n", $$1, $$2}'

dc.build: ## Сбилдить docker образы
	$(docker-compose-relative) build

dc.up: ## Создать и запустить docker образы
	$(docker-compose-relative) up -d

dc.start: ## Запустить docker образы
	$(docker-compose-relative) start

dc.down: ## Остановить и удалить docker образы
	$(docker-compose-relative) down

dc.stop: ## Остановить docker образы
	$(docker-compose-relative) stop

dc.restart: ## Перезапустить docker образы
	$(docker-compose-relative) down
	$(docker-compose-relative) up -d

dc.rebuild: ## Полная пересборка контейнеров (удаление образов + сборка + запуск)
	$(docker-compose-relative) down --rmi all --volumes --remove-orphans
	$(docker-compose-relative) build --no-cache
	$(docker-compose-relative) up -d

dc.reset: ## Полная очистка Docker системы (ОСТОРОЖНО!)
	$(docker-compose-relative) down --rmi all --volumes --remove-orphans
	docker system prune -a --volumes -f

dc.logs: ## Показать логи всех контейнеров
	$(docker-compose-relative) logs -f

dc.ps: ## Показать статус контейнеров
	$(docker-compose-relative) ps

composer.install: ## Запустить установку зависимостей composer
	$(docker-compose-relative) exec -u1000 $(PHP_CONTAINER_NAME) composer install

