# LavaChat Development Server Starter
# PowerShell script to start Laravel + Reverb

Write-Host "🚀 Starting LavaChat Development Environment" -ForegroundColor Green
Write-Host ""

# Start Reverb in background
Write-Host "📡 Starting Reverb WebSocket Server on port 8081..." -ForegroundColor Blue
Start-Process PowerShell -ArgumentList "-NoExit", "-Command", "cd '$PWD'; php artisan reverb:start --port=8081" -WindowStyle Normal

# Wait a moment for Reverb to start
Start-Sleep -Seconds 2

# Start Laravel development server
Write-Host "🌐 Starting Laravel Development Server on http://localhost:8000..." -ForegroundColor Green
Write-Host ""
Write-Host "Press Ctrl+C to stop the Laravel server" -ForegroundColor Yellow
Write-Host "Close the Reverb PowerShell window manually to stop WebSocket server" -ForegroundColor Yellow
Write-Host ""

php artisan serve
