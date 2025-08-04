@echo off
title Laravel + Reverb Server
echo.
echo ================================
echo Starting Laravel + Reverb Server
echo ================================
echo.

echo Starting Reverb WebSocket server on port 8081...
start "Reverb Server" cmd /k "php artisan reverb:start --port=8081"

echo Waiting 3 seconds for Reverb to start...
timeout /t 3 /nobreak >nul

echo Starting Laravel development server on http://localhost:8000...
php artisan serve

echo.
echo Press any key to exit...
pause >nul
