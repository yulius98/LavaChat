# Session Timeout Test Script

## Manual Testing Steps:

1. **Login to the application**
   - Go to: http://localhost:8000/login
   - Login dengan user credentials

2. **Wait for session to expire**
   - Session lifetime: 120 minutes (2 hours)
   - Untuk testing cepat, ubah SESSION_LIFETIME=1 di .env

3. **Try to access protected route**
   - Go to: http://localhost:8000/dashboard
   - Should redirect to login page with message

4. **Or test with this script**

```bash
# Quick test - set session to 1 minute
php artisan tinker
```

```php
// In tinker:
config(['session.lifetime' => 1]);
echo "Session lifetime set to 1 minute for testing";
exit
```

## Expected Behavior:

✅ **When session expires:**
- User should be redirected to `/login`
- Should see message: "Your session has expired. Please login again."
- Should NOT go to `/dashboard`

✅ **After login:**
- User should be redirected to `/chatify` (chat interface)
- Should NOT go to `/dashboard`

## Testing with Browser DevTools:

1. Open DevTools → Application → Storage
2. Clear all session cookies
3. Try to access protected route
4. Should redirect to login page
