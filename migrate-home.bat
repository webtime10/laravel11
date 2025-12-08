@echo off
echo Запуск миграции для home_descriptions...
echo.

REM Попробуем найти PHP в стандартных местах OSPanel
set PHP_PATH=

REM Проверяем разные возможные пути
if exist "C:\OSPanel635\modules\php\php8.3\php.exe" set PHP_PATH=C:\OSPanel635\modules\php\php8.3\php.exe
if exist "C:\OSPanel635\modules\php\php8.2\php.exe" set PHP_PATH=C:\OSPanel635\modules\php\php8.2\php.exe
if exist "C:\OSPanel635\modules\php\php8.1\php.exe" set PHP_PATH=C:\OSPanel635\modules\php\php8.1\php.exe
if exist "C:\OSPanel635\modules\php\php8.0\php.exe" set PHP_PATH=C:\OSPanel635\modules\php\php8.0\php.exe

if "%PHP_PATH%"=="" (
    echo ОШИБКА: PHP не найден в стандартных путях OSPanel!
    echo.
    echo Пожалуйста, выполните команды вручную:
    echo   1. Откройте OSPanel
    echo   2. Выберите "Терминал" или "Консоль"
    echo   3. Выполните: php artisan migrate
    echo.
    pause
    exit /b 1
)

echo Найден PHP: %PHP_PATH%
echo.

cd /d "%~dp0"

echo Выполняю миграцию...
"%PHP_PATH%" artisan migrate

echo.
echo Очищаю кэш...
"%PHP_PATH%" artisan cache:clear
"%PHP_PATH%" artisan config:clear
"%PHP_PATH%" artisan view:clear

echo.
echo Готово! Изменения применены.
echo.
pause

