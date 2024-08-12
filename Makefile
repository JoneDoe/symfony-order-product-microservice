composer: ## Composer install
	docker compose run --rm -v ./order:/usr/src/app order-app \
		composer install --no-scripts --prefer-dist --no-progress --no-interaction
	docker compose run --rm -v ./product:/usr/src/app product-app \
		composer install --no-scripts --prefer-dist --no-progress --no-interaction
migrate: ## Run migrations
	docker compose run --rm order-app bin/console doctrine:schema:update --force
	docker compose run --rm product-app bin/console doctrine:schema:update --force
copy-shared:
	cp -R common/ order/SharedBundle
	cp -R common/ product/SharedBundle
setup: copy-shared composer migrate ## Install the project
up: ## Start the containers
	docker compose up -d
down: ## Down the containers
	docker compose down
sync: ## Run sync products between services
	docker compose exec order-app bin/console messenger:consume -vv
help: ## List all available commands
	@grep -E '^[a-zA-Z_-]+:.*?## .*$$' $(firstword $(MAKEFILE_LIST)) | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[36m%-16s\033[0m %s\n", $$1, $$2}'

.DEFAULT_GOAL := help