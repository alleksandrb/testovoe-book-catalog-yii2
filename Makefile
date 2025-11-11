.PHONY: help migrate rbac-init seed init build up down restart logs shell worker user-create fix-permissions

# Default target
help:
	@echo "Available commands:"
	@echo "  make build          - Build Docker images"
	@echo "  make up             - Start all containers"
	@echo "  make down           - Stop all containers"
	@echo "  make restart        - Restart all containers"
	@echo "  make logs           - Show logs from all containers"
	@echo "  make shell          - Open shell in PHP container"
	@echo "  make init           - Initialize application (migrate, rbac, seed)"
	@echo "  make migrate        - Run database migrations"
	@echo "  make rbac-init      - Initialize RBAC"
	@echo "  make seed           - Seed database with test data"
	@echo "  make user-create    - Create a new user (usage: make user-create USER=admin PASS=admin)"
	@echo "  make fix-permissions - Fix file permissions for uploads and runtime"

# Build Docker images
build:
	docker-compose build

# Start containers
up:
	docker-compose up -d

# Stop containers
down:
	docker-compose down

# Restart containers
restart: down up

# Show logs
logs:
	docker-compose logs -f

# Open shell in PHP container
shell:
	docker-compose exec php bash

# Run migrations
migrate:
	@echo "Running migrations..."
	docker-compose exec -T php php yii migrate --interactive=0

# Initialize RBAC
rbac-init: migrate
	@echo "Initializing RBAC..."
	docker-compose exec -T php php yii migrate --migrationPath=@yii/rbac/migrations --interactive=0
	docker-compose exec -T php php yii rbac/init --interactive=0

# Seed database
seed: rbac-init
	@echo "Seeding database..."
	docker-compose exec -T php php yii seed || echo "Seed skipped or failed"

# Initialize application (all steps)
init: seed
	@echo "Application initialized successfully!"


# Create user
user-create:
	@if [ -z "$(USER)" ] || [ -z "$(PASS)" ]; then \
		echo "Usage: make user-create USER=username PASS=password"; \
		exit 1; \
	fi
	docker-compose exec -T php php yii user/create $(USER) $(PASS)

# Fix permissions
fix-permissions:
	@echo "Fixing permissions..."
	docker-compose exec -T php chmod -R 777 runtime web/assets web/uploads || true
	docker-compose exec -T php mkdir -p web/uploads/covers || true
	docker-compose exec -T php chmod -R 777 web/uploads || true
