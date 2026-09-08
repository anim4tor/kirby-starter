@echo off
set SCRIPT_DIR=%~dp0
set REPO_DIR=%SCRIPT_DIR%..
copy /Y "%SCRIPT_DIR%pre-push" "%REPO_DIR%\.git\hooks\pre-push" >nul
echo [OK] Git pre-push hook byl uspesne nainstalovan!
pause
