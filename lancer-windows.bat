@echo off
cd /d "%~dp0"
if exist C:\xampp\php\php.exe (
  C:\xampp\php\php.exe -S localhost:8000 router.php
) else (
  where php >nul 2>nul
  if errorlevel 1 (
    echo PHP introuvable. Voir README.md pour installer XAMPP ou utiliser le chemin de php.exe.
    pause
  ) else (
    php -S localhost:8000 router.php
  )
)
