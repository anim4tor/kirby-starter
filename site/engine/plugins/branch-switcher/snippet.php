<?php
// Display only in local or staging environment
$isAllowed = in_array($_SERVER['HTTP_HOST'] ?? '', ['localhost', '127.0.0.1'])
    || str_ends_with($_SERVER['HTTP_HOST'] ?? '', '.test')
    || str_ends_with($_SERVER['HTTP_HOST'] ?? '', '.local')
    || !empty($_GET['preview'])
    || (file_exists(kirby()->root('index') . '/.current-branch'));

if (!$isAllowed) return;
?>
<div id="u1-branch-switcher" style="position: fixed; bottom: 20px; right: 20px; z-index: 99999; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; font-size: 13px;">
  <div style="background: #1e293b; color: #f8fafc; border: 1px solid #334155; border-radius: 8px; box-shadow: 0 10px 25px -5px rgba(0,0,0,0.5); padding: 8px 12px; display: flex; align-items: center; gap: 8px;">
    <span style="display: inline-block; width: 8px; height: 8px; border-radius: 50%; background: #10b981;"></span>
    <span style="color: #94a3b8; font-weight: 500;">VÄ›tev:</span>
    <select id="u1-branch-select" style="background: #0f172a; color: #f8fafc; border: 1px solid #475569; border-radius: 4px; padding: 4px 8px; font-size: 12px; font-weight: 600; cursor: pointer; outline: none;">
      <option value="">NaÄŤĂ­tĂˇm...</option>
    </select>
  </div>
</div>
<script>
(function() {
  const select = document.getElementById('u1-branch-select');
  if (!select) return;

  fetch('<?= url("api-git-branches") ?>')
    .then(r => r.json())
    .then(data => {
      if (data.status !== 'success') return;
      select.innerHTML = '';
      data.branches.forEach(b => {
        const opt = document.createElement('option');
        opt.value = b.name;
        opt.textContent = b.name;
        if (b.active) opt.selected = true;
        select.appendChild(opt);
      });
    })
    .catch(() => { select.innerHTML = '<option>NedostupnĂ©</option>'; });

  select.addEventListener('change', function() {
    const branch = this.value;
    if (!branch || !confirm('PĹ™epnout web na vÄ›tev ' + branch + '?')) return;
    select.disabled = true;
    
    const formData = new FormData();
    formData.append('branch', branch);

    fetch('<?= url("api-git-switch") ?>', {
      method: 'POST',
      body: formData
    })
    .then(r => r.json())
    .then(data => {
      if (data.status === 'success') {
        window.location.reload();
      } else {
        alert('Chyba: ' + (data.message || 'NepodaĹ™ilo se pĹ™epnout vÄ›tev'));
        select.disabled = false;
      }
    })
    .catch(e => {
      alert('Chyba pĹ™i komunikaci se serverem.');
      select.disabled = false;
    });
  });
})();
</script>
