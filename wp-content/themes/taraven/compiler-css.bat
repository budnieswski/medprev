@echo off
  setlocal enableextensions

  rem DONT RENAME THIS FILE TO 'SASS/sass'
  rem because CMD try to run command sass
  rem then execute bat script again (if is named sass)

  rem Destroy batch file reference
  shift

  rem Call the subroutine to get the batch folder & go them
  call :getFolder batchFolder
  cd "%batchFolder%"

  echo Style Output:
  echo (1) Nested
  echo (2) Expanded
  echo (3) Compacts
  echo (4) Compressed
  set /p choice=""

  set "style="
  if "%choice%"=="1" set "style=--style nested"
  if "%choice%"=="2" set "style=--style expanded"
  if "%choice%"=="3" set "style=--style compact"
  if "%choice%"=="4" set "style=--style compressed"

  cmd /c "cls"
  cmd /k "sass --watch --sourcemap=none assets/css/main.sass:assets/css/main.css %style%"

:getFolder returnVar
  set "%~1=%~dp0" & exit /b
