#!/bin/bash
echo "╔══════════════════════════════════════════════╗"
echo "║  GHEVERHAN Commerce - Hostinger Deployer     ║"
echo "╚══════════════════════════════════════════════╝"
echo ""

BASEDIR="$(pwd)/laravel-app"

if [ ! -d "$BASEDIR" ]; then
    echo "ERROR: laravel-app/ not found in $(pwd)"
    exit 1
fi

cd "$BASEDIR"

# Step 1: Download Composer
echo "[1/8] Downloading Composer..."
if [ ! -f composer.phar ]; then
    curl -sS https://getcomposer.org/installer | php
fi
echo "  ✓ Composer ready"
echo ""

# Step 2: Install dependencies
echo "[2/8] Installing dependencies (this may take a few minutes)..."
php composer.phar install --no-dev --optimize-autoloader --no-interaction
echo "  ✓ Dependencies installed"
echo ""

# Step 3: Generate app key
echo "[3/8] Generating application key..."
php artisan key:generate --force
echo "  ✓ App key generated"
echo ""

# Step 4: Create bootstrap/cache if missing
echo "[4/8] Creating required directories..."
mkdir -p storage/framework/cache/data
mkdir -p storage/framework/sessions
mkdir -p storage/framework/views
mkdir -p storage/logs
mkdir -p bootstrap/cache
chmod -R 775 storage bootstrap/cache
echo "  ✓ Directories ready"
echo ""

# Step 5: Run migrations
echo "[5/8] Running database migrations..."
php artisan migrate --force
echo "  ✓ Migrations complete"
echo ""

# Step 6: Seed database
echo "[6/8] Seeding database..."
php artisan db:seed --force
echo "  ✓ Database seeded"
echo ""

# Step 7: Create storage link
echo "[7/8] Creating storage symlink..."
cd "$(pwd)/../"
PUBDIR="$(pwd)"
if [ ! -L "$PUBDIR/storage" ]; then
    ln -s "$BASEDIR/storage/app/public" "$PUBDIR/storage"
    echo "  ✓ Storage linked"
else
    echo "  ⓘ Storage link already exists"
fi
cd "$BASEDIR"
echo ""

# Step 8: Cache config
echo "[8/8] Caching configuration..."
php artisan config:cache
php artisan route:cache
php artisan view:cache
echo "  ✓ Config cached"
echo ""

# Check Vite assets
if [ -f "$(pwd)/../build/manifest.json" ]; then
    echo "  ✓ Vite manifest found — assets are built"
else
    echo "  ⚠ Vite assets NOT found. Upload build/ folder."
fi

echo ""
echo "╔══════════════════════════════════════════════╗"
echo "║  ✅ DEPLOYMENT COMPLETE!                     ║"
echo "╠══════════════════════════════════════════════╣"
echo "║                                              ║"
echo "║  Demo Accounts:                              ║"
echo "║  Admin:    admin@gheverhan.com / password     ║"
echo "║  Customer: customer@gheverhan.com / password  ║"
echo "║                                              ║"
echo "╚══════════════════════════════════════════════╝"

# Self-delete
echo ""
echo "Deleting deploy.sh..."
rm -f "$PUBDIR/deploy.sh"
rm -f "$PUBDIR/deploy.php"
echo "  ✓ Deploy scripts deleted"
