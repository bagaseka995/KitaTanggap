@echo off
echo ================================================
echo   KitaTanggap - Setup Database ^& Seeder
echo ================================================
echo.

REM Cek apakah MySQL XAMPP bisa connect
echo [1/3] Mengecek koneksi MySQL...
C:\xampp\mysql\bin\mysql.exe -u root -e "SELECT 1;" 2>nul
if %ERRORLEVEL% NEQ 0 (
    echo.
    echo [ERROR] MySQL tidak bisa diakses!
    echo Pastikan MySQL sudah dijalankan di XAMPP Control Panel.
    echo Tekan sembarang tombol untuk keluar...
    pause >nul
    exit /b 1
)
echo [OK] MySQL terkoneksi!

echo.
echo [2/3] Membuat database kitatanggap...
C:\xampp\mysql\bin\mysql.exe -u root -e "CREATE DATABASE IF NOT EXISTS kitatanggap CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
if %ERRORLEVEL% NEQ 0 (
    echo [ERROR] Gagal membuat database!
    pause >nul
    exit /b 1
)
echo [OK] Database 'kitatanggap' siap!

echo.
echo [3/3] Menjalankan migrasi dan seeder Laravel...
php artisan migrate:fresh --seed --force
if %ERRORLEVEL% NEQ 0 (
    echo [ERROR] Migrasi gagal! Cek pesan error di atas.
    pause >nul
    exit /b 1
)

echo.
echo ================================================
echo   BERHASIL! Data berhasil di-seed.
echo.
echo   Akun Admin:
echo     Email    : admin@kitatanggap.id
echo     Password : Admin@1234
echo.
echo   Jalankan server: php artisan serve
echo ================================================
pause
