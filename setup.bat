@echo off
echo ============================================
echo   GHEVERHAN Commerce Platform - Setup
echo ============================================

REM Copy .env if not exists
if not exist .env (
    copy .env.example .env
    echo [OK] .env file created
)

echo [..] Building Docker containers...
docker-compose build --no-cache

echo [..] Starting containers...
docker-compose up -d

echo [..] Waiting for MySQL to be ready (15s)...
timeout /t 15 /nobreak > nul

echo [..] Installing Composer dependencies...
docker-compose exec -T app composer install

echo [..] Generating application key...
docker-compose exec -T app php artisan key:generate

echo [..] Running database migrations...
docker-compose exec -T app php artisan migrate --force

echo [..] Seeding database...
docker-compose exec -T app php artisan db:seed --force

echo [..] Creating storage link...
docker-compose exec -T app php artisan storage:link

echo [..] Installing Node dependencies...
docker-compose exec -T node npm install

echo [..] Building assets...
docker-compose exec -T node npm run build

echo.
echo ============================================
echo   GHEVERHAN Commerce is ready!
echo   Open http://localhost:8000
echo ============================================
echo.
echo   Demo Accounts:
echo   Admin:    admin@gheverhan.com / password
echo   Customer: customer@gheverhan.com / password
echo ============================================
pause
