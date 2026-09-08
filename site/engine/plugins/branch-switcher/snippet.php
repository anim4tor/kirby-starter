<?php
$branchData = u1GetBranchData();
$current = !empty($branchData['current']) ? $branchData['current'] : 'v2';
$hiddenBranches = ['main', 'master', 'head', 'staging'];
if (in_array(strtolower($current), $hiddenBranches, true)) {
    $current = 'v2';
}
$branches = $branchData['branches'] ?? [];
$branches = array_filter($branches, function ($b) use ($hiddenBranches) {
    return !in_array(strtolower($b['name'] ?? ''), $hiddenBranches, true);
});
$safeCurrent = htmlspecialchars($current, ENT_QUOTES, 'UTF-8');
?>
<!-- U1 Branch Switcher Widget -->
<div id="u1-branch-switcher" class="u1-branch-switcher" data-current-branch="<?= $safeCurrent ?>">
    <div class="u1-bs-menu" id="u1-bs-menu" aria-hidden="true">
        <div class="u1-bs-header">
            <div class="u1-bs-title">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="6" y1="3" x2="6" y2="15"></line>
                    <circle cx="18" cy="6" r="3"></circle>
                    <circle cx="6" cy="18" r="3"></circle>
                    <path d="M18 9a9 9 0 0 1-9 9"></path>
                </svg>
                <span>Dostupné verze webu</span>
            </div>
            <button type="button" class="u1-bs-close" id="u1-bs-close" aria-label="Zavřít menu">&times;</button>
        </div>
        <div class="u1-bs-list" id="u1-bs-list">
            <?php foreach ($branches as $b): ?>
                <?php 
                $isActive = $b['active'];
                $safeName = htmlspecialchars($b['name'], ENT_QUOTES, 'UTF-8');
                ?>
                <button type="button" 
                        class="u1-bs-item <?= $isActive ? 'is-active' : '' ?>" 
                        data-branch="<?= $safeName ?>" 
                        <?= $isActive ? 'disabled' : '' ?>>
                    <div class="u1-bs-item-info">
                        <span class="u1-bs-item-icon">
                            <?php if ($isActive): ?>
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="#10b981" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>
                            <?php else: ?>
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="4"></circle></svg>
                            <?php endif ?>
                        </span>
                        <span class="u1-bs-item-name"><?= $safeName ?></span>
                    </div>
                    <?php if ($isActive): ?>
                        <span class="u1-bs-badge">Aktivní</span>
                    <?php else: ?>
                        <span class="u1-bs-item-arrow">Přepnout &rarr;</span>
                    <?php endif ?>
                </button>
            <?php endforeach ?>
        </div>
        <div class="u1-bs-status" id="u1-bs-status"></div>
    </div>

    <button type="button" class="u1-bs-trigger" id="u1-bs-trigger" aria-expanded="false" aria-label="Přepnout verzi projektu">
        <span class="u1-bs-pulse-dot"></span>
        <svg class="u1-bs-trigger-icon" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
            <line x1="6" y1="3" x2="6" y2="15"></line>
            <circle cx="18" cy="6" r="3"></circle>
            <circle cx="6" cy="18" r="3"></circle>
            <path d="M18 9a9 9 0 0 1-9 9"></path>
        </svg>
        <span class="u1-bs-trigger-label" id="u1-bs-current-label"><?= $safeCurrent ?></span>
        <svg class="u1-bs-trigger-chevron" width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
            <polyline points="6 9 12 15 18 9"></polyline>
        </svg>
    </button>
</div>

<style>
.u1-branch-switcher {
    position: fixed;
    top: 24px;
    left: 24px;
    z-index: 9999999;
    font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
    font-size: 13px;
    line-height: 1.4;
    user-select: none;
    -webkit-font-smoothing: antialiased;
}
.u1-bs-trigger {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: rgba(18, 18, 20, 0.90);
    backdrop-filter: blur(16px) saturate(180%);
    -webkit-backdrop-filter: blur(16px) saturate(180%);
    color: #f3f4f6;
    border: 1px solid rgba(255, 255, 255, 0.16);
    border-radius: 9999px;
    padding: 8px 14px 8px 12px;
    cursor: pointer;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.4), 0 0 0 1px rgba(0, 0, 0, 0.2);
    transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
}
.u1-bs-trigger:hover {
    background: rgba(28, 28, 32, 0.98);
    border-color: rgba(255, 255, 255, 0.3);
    transform: translateY(-1px);
    box-shadow: 0 6px 24px rgba(0, 0, 0, 0.5);
}
.u1-bs-trigger:active {
    transform: translateY(0px) scale(0.98);
}
.u1-bs-pulse-dot {
    width: 7px;
    height: 7px;
    border-radius: 50%;
    background: #10b981;
    box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.7);
    animation: u1-pulse 2s infinite;
    flex-shrink: 0;
}
@keyframes u1-pulse {
    0% { box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.7); }
    70% { box-shadow: 0 0 0 6px rgba(16, 185, 129, 0); }
    100% { box-shadow: 0 0 0 0 rgba(16, 185, 129, 0); }
}
.u1-bs-trigger-icon {
    opacity: 0.8;
    flex-shrink: 0;
}
.u1-bs-trigger-label {
    font-weight: 500;
    letter-spacing: 0.01em;
    color: #fff;
    max-width: 150px;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}
.u1-bs-trigger-chevron {
    opacity: 0.5;
    transition: transform 0.25s cubic-bezier(0.16, 1, 0.3, 1);
}
.u1-branch-switcher.is-open .u1-bs-trigger-chevron {
    transform: rotate(180deg);
}
.u1-bs-menu {
    position: absolute;
    top: calc(100% + 10px);
    left: 0;
    width: 270px;
    background: rgba(18, 18, 22, 0.95);
    backdrop-filter: blur(20px) saturate(180%);
    -webkit-backdrop-filter: blur(20px) saturate(180%);
    border: 1px solid rgba(255, 255, 255, 0.14);
    border-radius: 14px;
    box-shadow: 0 16px 36px rgba(0, 0, 0, 0.6), 0 0 0 1px rgba(255, 255, 255, 0.05);
    opacity: 0;
    visibility: hidden;
    transform: translateY(-8px) scale(0.96);
    transform-origin: top left;
    transition: all 0.22s cubic-bezier(0.16, 1, 0.3, 1);
    pointer-events: none;
    overflow: hidden;
}
.u1-branch-switcher.is-open .u1-bs-menu {
    opacity: 1;
    visibility: visible;
    transform: translateY(0) scale(1);
    pointer-events: auto;
}
.u1-bs-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 12px 14px 10px 14px;
    border-bottom: 1px solid rgba(255, 255, 255, 0.08);
}
.u1-bs-title {
    display: flex;
    align-items: center;
    gap: 6px;
    font-size: 11px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.06em;
    color: rgba(255, 255, 255, 0.6);
}
.u1-bs-close {
    background: transparent;
    border: none;
    color: rgba(255, 255, 255, 0.5);
    font-size: 18px;
    line-height: 1;
    cursor: pointer;
    padding: 0 4px;
    border-radius: 4px;
    transition: color 0.15s;
}
.u1-bs-close:hover {
    color: #fff;
}
.u1-bs-list {
    padding: 6px;
    max-height: 280px;
    overflow-y: auto;
}
.u1-bs-list::-webkit-scrollbar {
    width: 4px;
}
.u1-bs-list::-webkit-scrollbar-thumb {
    background: rgba(255, 255, 255, 0.2);
    border-radius: 4px;
}
.u1-bs-item {
    display: flex;
    align-items: center;
    justify-content: space-between;
    width: 100%;
    padding: 8px 10px;
    border-radius: 8px;
    background: transparent;
    border: none;
    color: #d1d5db;
    font-size: 12.5px;
    cursor: pointer;
    text-align: left;
    transition: all 0.15s ease;
}
.u1-bs-item:hover:not(:disabled) {
    background: rgba(255, 255, 255, 0.08);
    color: #ffffff;
}
.u1-bs-item.is-active {
    background: rgba(16, 185, 129, 0.12);
    color: #34d399;
    cursor: default;
}
.u1-bs-item-info {
    display: flex;
    align-items: center;
    gap: 8px;
    overflow: hidden;
}
.u1-bs-item-icon {
    display: flex;
    align-items: center;
    opacity: 0.7;
    flex-shrink: 0;
}
.u1-bs-item.is-active .u1-bs-item-icon {
    opacity: 1;
}
.u1-bs-item-name {
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
    font-weight: 500;
}
.u1-bs-badge {
    font-size: 10px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    background: rgba(16, 185, 129, 0.2);
    color: #10b981;
    padding: 2px 6px;
    border-radius: 4px;
    flex-shrink: 0;
}
.u1-bs-item-arrow {
    font-size: 11px;
    color: rgba(255, 255, 255, 0.35);
    transition: color 0.15s, transform 0.15s;
    flex-shrink: 0;
}
.u1-bs-item:hover .u1-bs-item-arrow {
    color: #ffffff;
    transform: translateX(2px);
}
.u1-bs-status {
    display: none;
    padding: 8px 12px;
    font-size: 11.5px;
    text-align: center;
    border-top: 1px solid rgba(255, 255, 255, 0.08);
}
.u1-bs-status.is-loading {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
    color: #93c5fd;
    background: rgba(59, 130, 246, 0.12);
}
.u1-bs-status.is-error {
    display: block;
    color: #f87171;
    background: rgba(239, 68, 68, 0.12);
    word-break: break-word;
}
.u1-bs-status.is-success {
    display: block;
    color: #34d399;
    background: rgba(16, 185, 129, 0.12);
}
.u1-bs-spinner {
    width: 12px;
    height: 12px;
    border: 2px solid rgba(147, 197, 253, 0.3);
    border-top-color: #93c5fd;
    border-radius: 50%;
    animation: u1-spin 0.7s linear infinite;
}
@keyframes u1-spin {
    to { transform: rotate(360deg); }
}
@media (max-width: 640px) {
    .u1-branch-switcher {
        top: 16px;
        left: 16px;
    }
    .u1-bs-menu {
        width: 250px;
    }
}
</style>

<script>
(function() {
    const root = document.getElementById('u1-branch-switcher');
    if (!root) return;

    const trigger = document.getElementById('u1-bs-trigger');
    const closeBtn = document.getElementById('u1-bs-close');
    const statusEl = document.getElementById('u1-bs-status');
    const listEl = document.getElementById('u1-bs-list');
    let isBusy = false;

    function toggleMenu(forceOpen = null) {
        const isOpen = forceOpen !== null ? forceOpen : !root.classList.contains('is-open');
        if (isOpen) {
            root.classList.add('is-open');
            trigger.setAttribute('aria-expanded', 'true');
            fetchBranches();
        } else {
            root.classList.remove('is-open');
            trigger.setAttribute('aria-expanded', 'false');
        }
    }

    trigger.addEventListener('click', function(e) {
        e.stopPropagation();
        toggleMenu();
    });

    closeBtn.addEventListener('click', function(e) {
        e.stopPropagation();
        toggleMenu(false);
    });

    document.addEventListener('click', function(e) {
        if (!root.contains(e.target)) {
            toggleMenu(false);
        }
    });

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && root.classList.contains('is-open')) {
            toggleMenu(false);
        }
    });

    const baseUrl = '<?= rtrim(kirby()->url(), "/") ?>';
    const hiddenBranches = ['main', 'master', 'head', 'staging'];

    async function fetchBranches() {
        try {
            const res = await fetch(baseUrl + '/git-branches.json', { cache: 'no-store' });
            if (!res.ok) return;
            const data = await res.json();
            if (data.status === 'success' && Array.isArray(data.branches)) {
                renderBranches(data.branches, data.current);
            }
        } catch (err) {
            console.warn('[BranchSwitcher] Failed to fetch branches:', err);
        }
    }

    function renderBranches(branches, current) {
        if (hiddenBranches.includes((current || '').toLowerCase())) {
            current = 'v2';
        }
        document.getElementById('u1-bs-current-label').textContent = current;
        root.dataset.currentBranch = current;

        const filtered = branches.filter(function(b) {
            return !hiddenBranches.includes((b.name || '').toLowerCase());
        });

        listEl.innerHTML = filtered.map(function(b) {
            const isActive = b.name === current;
            const iconSvg = isActive 
                ? '<svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="#10b981" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>'
                : '<svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="4"></circle></svg>';
            const badgeHtml = isActive 
                ? '<span class="u1-bs-badge">Aktivní</span>' 
                : '<span class="u1-bs-item-arrow">Přepnout &rarr;</span>';

            return '<button type="button" class="u1-bs-item ' + (isActive ? 'is-active' : '') + '" data-branch="' + b.name + '" ' + (isActive ? 'disabled' : '') + '>' +
                '<div class="u1-bs-item-info">' +
                    '<span class="u1-bs-item-icon">' + iconSvg + '</span>' +
                    '<span class="u1-bs-item-name">' + b.name + '</span>' +
                '</div>' +
                badgeHtml +
            '</button>';
        }).join('');
    }

    listEl.addEventListener('click', async function(e) {
        const item = e.target.closest('.u1-bs-item');
        if (!item || item.classList.contains('is-active') || isBusy) return;

        const targetBranch = item.dataset.branch;
        if (!targetBranch) return;

        if (!confirm('Opravdu chcete přepnout web na verzi "' + targetBranch + '"?')) {
            return;
        }

        isBusy = true;
        statusEl.className = 'u1-bs-status is-loading';
        statusEl.innerHTML = '<span class="u1-bs-spinner"></span> Přepínám na "' + targetBranch + '"...';

        listEl.querySelectorAll('button').forEach(function(btn) { btn.disabled = true; });

        try {
            const formData = new FormData();
            formData.append('branch', targetBranch);

            const res = await fetch(baseUrl + '/git-switch.json', {
                method: 'POST',
                body: formData
            });

            const result = await res.json();

            if (res.ok && result.status === 'success') {
                statusEl.className = 'u1-bs-status is-success';
                statusEl.textContent = 'Hotovo! Přenačítám stránku...';
                setTimeout(function() {
                    window.location.reload();
                }, 400);
            } else {
                throw new Error(result.message || 'Nepodařilo se přepnout větev.');
            }
        } catch (err) {
            isBusy = false;
            statusEl.className = 'u1-bs-status is-error';
            statusEl.textContent = err.message || 'Chyba při přepnutí větve.';
            listEl.querySelectorAll('button').forEach(function(btn) {
                if (btn.dataset.branch !== root.dataset.currentBranch) {
                    btn.disabled = false;
                }
            });
        }
    });
})();
</script>
