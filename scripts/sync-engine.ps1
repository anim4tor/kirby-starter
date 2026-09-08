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
Write-Host "AktuĂˇlnĂ­ vÄ›tev: $currentBranch" -ForegroundColor Yellow

if ($Action -eq "status") {
    git fetch origin engine 2>$null
    git diff --stat origin/engine -- site/engine site/config
    exit 0
}

if ($Action -eq "pull") {
    Write-Host "Stahuji engine z origin/engine..." -ForegroundColor Cyan
    git fetch origin engine
    git checkout origin/engine -- site/engine site/config
    Write-Host "Engine ĂşspÄ›ĹˇnÄ› aktualizovĂˇn." -ForegroundColor Green
    exit 0
}

if ($Action -eq "push" -or $Action -eq "all") {
    Write-Host "OdesĂ­lĂˇm engine do centrĂˇlnĂ­ vÄ›tve 'origin/engine'..." -ForegroundColor Cyan
    git push --no-verify origin "$($currentBranch):refs/heads/engine"

    if (-not $NoPropagate) {
        $branches = (git branch -r | Select-String -Pattern "origin/" | ForEach-Object { $_.Line.Trim() -replace 'origin/', '' } | Where-Object { $_ -ne "content" -and $_ -ne "staging" -and $_ -ne "HEAD" -and $_ -ne $currentBranch })

        foreach ($b in $branches) {
            Write-Host " -> Aktualizuji vÄ›tev $b..." -ForegroundColor Yellow
            cmd /c "git checkout --quiet $b && git checkout $currentBranch -- site/engine site/config"
            $diff = (git status --porcelain site/engine site/config)
            if ($diff) {
                cmd /c "git add site/engine site/config && git commit --quiet -m ""chore(engine): sync backend from $currentBranch"" && git push --no-verify origin $b --quiet"
                Write-Host "    [OK] VÄ›tev $b aktualizovĂˇna." -ForegroundColor Green
            } else {
                Write-Host "    [SKIP] VÄ›tev $b je jiĹľ aktuĂˇlnĂ­." -ForegroundColor Gray
            }
        }
        cmd /c "git checkout --quiet $currentBranch"
    }
    Write-Host "Synchronizace enginu dokonÄŤena!" -ForegroundColor Green
}
