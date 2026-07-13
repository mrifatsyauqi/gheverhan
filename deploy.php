<?php
/**
 * GHEVERHAN Commerce Platform - Hostinger Deploy Script
 * 
 * Upload file ini ke public_html/gheverhan.store/ dan jalankan di browser:
 * https://gheverhan.store/deploy.php
 * 
 * Script ini akan:
 * 1. Download Composer
 * 2. Install dependencies
 * 3. Generate app key
 * 4. Run migrations
 * 5. Seed database
 * 6. Create storage link
 * 7. Cache config, routes, views
 * 8. Self-delete
 */

set_time_limit(600);
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<pre>\n";
echo "╔══════════════════════════════════════════════╗\n";
echo "║  GHEVERHAN Commerce - Hostinger Deployer     ║\n";
echo "╚══════════════════════════════════════════════╝\n\n";

$publicDir = __DIR__;
$baseDir = $publicDir . '/laravel-app';

// Fallback: if deploy.php is inside public/ folder (local dev)
if (!is_dir($baseDir)) {
    $baseDir = $publicDir . '/../laravel-app';
}

if (!is_dir($baseDir)) {
    die("ERROR: laravel-app directory not found at: $baseDir\nPlease upload the laravel-app folder first.\n");
}

// Fix for Hostinger: Set COMPOSER_HOME to a writable local directory
$composerHome = $baseDir . '/.composer';
if (!is_dir($composerHome)) {
    mkdir($composerHome, 0755, true);
}
putenv("COMPOSER_HOME={$composerHome}");

// Step 1: Download Composer
echo "[1/8] Downloading Composer...\n";
$composerPhar = $baseDir . '/composer.phar';
if (!file_exists($composerPhar)) {
    $composerInstaller = file_get_contents('https://getcomposer.org/installer');
    file_put_contents($baseDir . '/composer-setup.php', $composerInstaller);
    
    $cwd = getcwd();
    chdir($baseDir);
    passthru('php composer-setup.php 2>&1');
    chdir($cwd);
    unlink($baseDir . '/composer-setup.php');
    
    if (!file_exists($composerPhar)) {
        die("ERROR: Failed to download Composer.\n");
    }
}
echo "  ✓ Composer ready\n\n";

// Step 2: Install dependencies
echo "[2/8] Installing Composer dependencies (this may take a few minutes)...\n";
$cwd = getcwd();
chdir($baseDir);
passthru('php composer.phar install --no-dev --optimize-autoloader --no-interaction 2>&1');
chdir($cwd);
echo "  ✓ Dependencies installed\n\n";

// Step 3: Generate app key
echo "[3/8] Generating application key...\n";
chdir($baseDir);
passthru('php artisan key:generate --force 2>&1');
chdir($cwd);
echo "  ✓ App key generated\n\n";

// Ensure bootstrap/cache exists
$bootstrapCacheDir = $baseDir . '/bootstrap/cache';
if (!is_dir($bootstrapCacheDir)) {
    mkdir($bootstrapCacheDir, 0777, true);
}

// Step 4: Run migrations
echo "[4/8] Running database migrations...\n";
chdir($baseDir);
passthru('php artisan migrate --force 2>&1');
chdir($cwd);
echo "  ✓ Migrations complete\n\n";

// Step 5: Seed database
echo "[5/8] Seeding database...\n";
chdir($baseDir);
passthru('php artisan db:seed --force 2>&1');
chdir($cwd);
echo "  ✓ Database seeded\n\n";

// Step 6: Storage link
echo "[6/8] Creating storage symlink...\n";
$storageLink = $publicDir . '/storage';
$storageTarget = $baseDir . '/storage/app/public';

if (!is_link($storageLink) && !is_dir($storageLink)) {
    if (function_exists('symlink')) {
        symlink($storageTarget, $storageLink);
        echo "  ✓ Storage linked via PHP\n\n";
    } else {
        // Fallback using shell command if PHP symlink is disabled
        passthru("ln -s '{$storageTarget}' '{$storageLink}'");
        echo "  ✓ Storage linked via Shell\n\n";
    }
} else {
    echo "  ⓘ Storage link already exists\n\n";
}

// Step 7: Cache config
echo "[7/8] Caching configuration...\n";
chdir($baseDir);
passthru('php artisan config:cache 2>&1');
passthru('php artisan route:cache 2>&1');
passthru('php artisan view:cache 2>&1');
chdir($cwd);
echo "  ✓ Config cached\n\n";

// Step 8: Build Vite assets info
echo "[8/8] Asset build status...\n";
$manifestPath = $publicDir . '/build/manifest.json';
if (file_exists($manifestPath)) {
    echo "  ✓ Vite manifest found — assets are built\n\n";
} else {
    echo "  ⚠ Vite assets NOT built. You need to run 'npm run build' locally\n";
    echo "    and upload the public/build/ folder.\n\n";
}

echo "\n╔══════════════════════════════════════════════╗\n";
echo "║  ✅ DEPLOYMENT COMPLETE!                     ║\n";
echo "╠══════════════════════════════════════════════╣\n";
echo "║                                              ║\n";
echo "║  🌐 URL: https://project-syauqi.xyz          ║\n";
echo "║                                              ║\n";
echo "║  Demo Accounts:                              ║\n";
echo "║  Admin:    admin@gheverhan.com / password     ║\n";
echo "║  Customer: customer@gheverhan.com / password  ║\n";
echo "║                                              ║\n";
echo "╚══════════════════════════════════════════════╝\n";

// Self-delete for security
echo "\n⚠ IMPORTANT: Delete this file now for security!\n";
echo "  Deleting deploy.php...\n";
unlink(__FILE__);
echo "  ✓ deploy.php deleted\n";
echo "</pre>\n";
