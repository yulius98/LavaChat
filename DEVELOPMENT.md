# LavaChat Development Setup

## Starting Development Environment

Sekarang Reverb WebSocket server sudah dikonfigurasi untuk menggunakan port 8081 secara default. Berikut adalah berbagai cara untuk menjalankan aplikasi:

### 1. Manual (Recommended for Development)

Buka 2 terminal terpisah:

**Terminal 1 - Reverb WebSocket Server:**
```bash
php artisan reverb:start
```
Port: 8081 (default)

**Terminal 2 - Laravel Development Server:**
```bash
php artisan serve
```
Port: 8000 (default)

### 2. Menggunakan Batch File (Windows)

```bash
# Menjalankan kedua server dalam terminal terpisah
./start-dev.bat
```

### 3. Menggunakan NPM Scripts

```bash
# Menjalankan Laravel + Reverb
npm run start

# Menjalankan Laravel + Reverb + Vite (untuk development dengan hot reload)
npm run dev:full
```

### 4. Menggunakan Custom Artisan Command

```bash
# Command untuk melihat informasi setup
php artisan start:dev

# Command untuk menjalankan kedua server (experimental)
php artisan serve:reverb
```

## Konfigurasi Port

### Current Configuration (.env):
- **Laravel Development Server**: http://localhost:8000
- **Reverb WebSocket Server**: http://localhost:8081
- **Database**: PostgreSQL (port 5432)

### Mengubah Port:

**Reverb Port:**
```bash
# Di .env file
REVERB_PORT=8081
REVERB_SERVER_PORT=8081

# Atau menggunakan parameter
php artisan reverb:start --port=8082
```

**Laravel Serve Port:**
```bash
php artisan serve --port=8001
```

## Troubleshooting

### Port Already in Use Error:
```
Failed to listen on "tcp://0.0.0.0:8080": EACCES
```

**Solution:**
1. Port 8080 digunakan oleh Apache Laragon
2. Gunakan port 8081 (sudah dikonfigurasi)
3. Atau stop Apache: Menu Laragon → Apache → Stop

### Check Active Ports:
```bash
netstat -ano | findstr :8081
```

### Kill Process on Port:
```bash
# Find PID
netstat -ano | findstr :8081

# Kill process (replace PID)
taskkill /PID <PID> /F
```

## Browser Access

- **Application**: http://localhost:8000
- **WebSocket Connection**: ws://localhost:8081
- **Database Admin**: http://localhost/phpMyAdmin (Laragon)

## Development Workflow

1. Start Reverb: `php artisan reverb:start`
2. Start Laravel: `php artisan serve` 
3. Start Vite (if needed): `npm run dev`
4. Access app: http://localhost:8000

## Package.json Scripts

```json
{
  "scripts": {
    "serve": "php artisan serve",
    "reverb": "php artisan reverb:start --port=8081", 
    "start": "concurrently \"npm run reverb\" \"npm run serve\"",
    "dev:full": "concurrently \"npm run reverb\" \"npm run serve\" \"npm run dev\""
  }
}
```
