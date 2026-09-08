# 🚀 Kirby Multiverse Starter

Moderní a vyčištěný Kirby Starter s automatickou synchronizací Kirby enginu napříč verzemi, přepínačem větví na hostingu a obousměrným verzováním obsahu z Kirby Panelu.

## 📌 Architektura 3 startovacích větví
* **`engine`** – Centrální jádro (Kirby CMS, blueprinty, pluginy, konfigurace).
* **`content`** – Klientský obsah (`public/content/`) synchronizovaný z Panelu.
* **`design`** – Výchozí pracovní větev pro frontend a šablony. (Z ní můžete kdykoliv odbočit `v1`, `v2`, `v3`...).

## ⚡ Rychlý start nového projektu

### 1. Založení na GitHubu
1. V repozitáři šablony klikněte na **"Use this template"** -> **"Create a new repository"**.
2. Zaškrtněte **"Include all branches"** a pojmenujte projekt (např. `anim4tor/novy-web`).

### 2. Lokální nastavení
1. Naklonujte repozitář:
   ```bash
   git clone https://github.com/anim4tor/novy-web.git d:\WampServer\www\novy-web
   cd d:\WampServer\www\novy-web
   ```
2. Otevřete `project.json` a upravte název repozitáře, tajný klíč a cesty k testovacímu serveru.
3. Nainstalujte Git hook:
   Spusťte `scripts/install-hooks.bat`.

### 3. Nasazení na hosting
1. Nahrajte `deploy.php` do složky na serveru.
2. V prohlížeči otevřete inicializační URL:
   `https://jiriklusak.cz/projects/novy-web/deploy.php?secret=VAS_SECRET&branch=design`
