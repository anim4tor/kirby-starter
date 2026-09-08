param (
    [Parameter(Position = 0)]
    [ValidateSet("push", "pull", "status", "all")]
    [string]$Action = "push",

    [Parameter(Position = 1)]
    [switch]$NoPropagate = $false
)

$ErrorActionPreference = "Continue"
$RepoRoot = Resolve-Path (Join-Path $PSScriptRoot "..")
Set-Location $RepoRoot

Write-Host "================================================" -ForegroundColor Cyan
Write-Host " Kirby Engine Sync Tool: $Action" -ForegroundColor Cyan
Write-Host "================================================" -ForegroundColor Cyan

$currentBranch = (git branch --show-current).Trim()
Write-Host "Aktuální větev: $currentBranch" -ForegroundColor Yellow

if ($Action -eq "status") {
    git fetch origin engine 2>$null
    git diff --stat origin/engine -- site/engine site/config
    exit 0
}

if ($Action -eq "pull") {
    Write-Host "Stahuji engine z origin/engine..." -ForegroundColor Cyan
    git fetch origin engine
    git checkout origin/engine -- site/engine site/config
    Write-Host "Engine úspěšně aktualizován." -ForegroundColor Green
    exit 0
}

if ($Action -eq "push" -or $Action -eq "all") {
    Write-Host "Odesílám engine do centrální větve 'origin/engine'..." -ForegroundColor Cyan
    git push --no-verify origin "$($currentBranch):refs/heads/engine"

    if (-not $NoPropagate) {
        $branches = (git branch -r | Select-String -Pattern "origin/" | ForEach-Object { $_.Line.Trim() -replace 'origin/', '' } | Where-Object { $_ -ne "content" -and $_ -ne "staging" -and $_ -ne "HEAD" -and $_ -ne $currentBranch })

        foreach ($b in $branches) {
            Write-Host " -> Aktualizuji větev $b..." -ForegroundColor Yellow
            cmd /c "git checkout --quiet $b && git checkout $currentBranch -- site/engine site/config"
            $diff = (git status --porcelain site/engine site/config)
            if ($diff) {
                cmd /c "git add site/engine site/config && git commit --quiet -m ""chore(engine): sync backend from $currentBranch"" && git push --no-verify origin $b --quiet"
                Write-Host "    [OK] Větev $b aktualizována." -ForegroundColor Green
            } else {
                Write-Host "    [SKIP] Větev $b je již aktuální." -ForegroundColor Gray
            }
        }
        cmd /c "git checkout --quiet $currentBranch"
    }
    Write-Host "Synchronizace enginu dokončena!" -ForegroundColor Green
}
