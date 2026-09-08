@echo off
powershell -ExecutionPolicy Bypass -File "%~dp0scripts\sync-engine.ps1" push
pause
