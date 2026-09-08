param (
    [string]$Repo = "",
    [string]$Secret = ""
)

$RepoRoot = Resolve-Path (Join-Path $PSScriptRoot "..")
Set-Location $RepoRoot

Write-Host "================================================" -ForegroundColor Cyan
Write-Host " Kirby Project Initializer Wizard" -ForegroundColor Cyan
Write-Host "================================================" -ForegroundColor Cyan

if (-not $Repo) {
    $Repo = Read-Host "Zadejte nazev GitHub repozitare (napr. anim4tor/muj-novy-web)"
}

if (-not $Secret) {
    $Secret = -join ((65..90) + (97..122) + (48..57) | Get-Random -Count 16 | ForEach-Object {[char]$_})
}

$configFile = "$RepoRoot\project.json"
if (Test-Path $configFile) {
    $json = Get-Content $configFile -Raw | ConvertFrom-Json
    $json.github.repo = $Repo
    $json.github.secret = $Secret
    $slug = ($Repo -split "/")[-1]
    $json.project.name = $slug
    $json.servers.staging.url = "https://jiriklusak.cz/projects/$slug"
    $json.servers.staging.base_path = "/projects/$slug"
    $json.servers.staging.ftp.path = "public_html/projects/$slug/"
    
    $json | ConvertTo-Json -Depth 10 | Set-Content $configFile -Encoding UTF8
    Write-Host "[OK] project.json aktualizovan s repozitarem: $Repo" -ForegroundColor Green
    Write-Host "[OK] Vygenerovan tajny klic: $Secret" -ForegroundColor Green
}

# Git initialization & 3 starter branches
Write-Host "`nInicializuji Git vetve (engine, content, design)..." -ForegroundColor Cyan
git init
git branch -M design
git add .
git commit -m "feat(starter): initial project structure"
git remote remove origin 2>$null
git remote add origin "https://github.com/$Repo.git"

# Create engine & content branches
git branch engine
git branch content

Write-Host "`n================================================" -ForegroundColor Green
Write-Host " Projekt je pripraven!" -ForegroundColor Green
Write-Host " Nyni staci odeslat vetve na GitHub:" -ForegroundColor Yellow
Write-Host "   git push -u origin design" -ForegroundColor White
Write-Host "   git push -u origin engine" -ForegroundColor White
Write-Host "   git push -u origin content" -ForegroundColor White
Write-Host "================================================" -ForegroundColor Green
