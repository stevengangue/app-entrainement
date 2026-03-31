@echo off
echo ========================================
echo   FitTrack Pro - Application d'entrainement
echo ========================================
echo.
echo Démarrage du serveur Laravel sur le port 8080...
start "Laravel Server" cmd /k "php artisan serve --port=8080"
echo.
echo Démarrage de Vite pour les assets...
start "Vite Server" cmd /k "npm run dev"
echo.
echo ========================================
echo   Application demarree !
echo   Laravel: http://localhost:8080
echo   Vite: http://localhost:5173
echo ========================================
echo.
pause