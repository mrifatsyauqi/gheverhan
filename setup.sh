#!/bin/bash

# GHEVERHAN Commerce Platform - Setup Script
# Run this after installing Docker Desktop

set -e

echo "============================================"
echo "  GHEVERHAN Commerce Platform - Setup"
echo "============================================"

# Copy .env if not exists
if [ ! -f .env ]; then
    cp .env.example .env
    echo "✓ .env file created"
fi

# Build and start containers
echo "→ Building Docker containers..."
docker-compose build --no-cache

echo "→ Starting containers..."
docker-compose up -d

# Wait for MySQL to be ready
echo "→ Waiting for MySQL..."
sleep 10

# Install PHP dependencies
echo "→ Installing Composer dependencies..."
docker-compose exec -T app composer install

# Generate application key
echo "→ Generating application key..."
docker-compose exec -T app php artisan key:generate

# Run migrations
echo "→ Running database migrations..."
docker-compose exec -T app php artisan migrate --force

# Seed database
echo "→ Seeding database..."
docker-compose exec -T app php artisan db:seed --force

# Create storage link
echo "→ Creating storage link..."
docker-compose exec -T app php artisan storage:link

# Install Node dependencies and build assets
echo "→ Installing Node dependencies..."
docker-compose exec -T node npm install

echo "→ Building assets..."
docker-compose exec -T node npm run build

echo ""
echo "============================================"
echo "  ✓ GHEVERHAN Commerce is ready!"
echo "  → Open http://localhost:8000"
echo "============================================"
echo ""
echo "  Demo Accounts:"
echo "  Admin:    admin@gheverhan.com / password"
echo "  Customer: customer@gheverhan.com / password"
echo "============================================"
