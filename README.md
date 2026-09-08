# đźš€ Kirby Multiverse Starter

ModernĂ­ a vyÄŤiĹˇtÄ›nĂ˝ Kirby Starter s automatickou synchronizacĂ­ Kirby enginu napĹ™Ă­ÄŤ verzemi, pĹ™epĂ­naÄŤem vÄ›tvĂ­ na hostingu a obousmÄ›rnĂ˝m verzovĂˇnĂ­m obsahu z Kirby Panelu.

## đź“ Architektura 3 startovacĂ­ch vÄ›tvĂ­
* **`engine`** â€“ CentrĂˇlnĂ­ jĂˇdro (Kirby CMS, blueprinty, pluginy, konfigurace).
* **`content`** â€“ KlientskĂ˝ obsah (`public/content/`) synchronizovanĂ˝ z Panelu.
* **`design`** â€“ VĂ˝chozĂ­ pracovnĂ­ vÄ›tev pro frontend a Ĺˇablony. (Z nĂ­ mĹŻĹľete kdykoliv odboÄŤit `v1`, `v2`, `v3`...).

## âšˇ RychlĂ˝ start novĂ©ho projektu

### 1. ZaloĹľenĂ­ na GitHubu
1. V repozitĂˇĹ™i Ĺˇablony kliknÄ›te na **"Use this template"** -> **"Create a new repository"**.
2. ZaĹˇkrtnÄ›te **"Include all branches"** a pojmenujte projekt (napĹ™. `anim4tor/novy-web`).

### 2. LokĂˇlnĂ­ nastavenĂ­
1. Naklonujte repozitĂˇĹ™:
   ```bash
   git clone https://github.com/anim4tor/novy-web.git d:\WampServer\www\novy-web
   cd d:\WampServer\www\novy-web
   ```
2. OtevĹ™ete `project.json` a upravte nĂˇzev repozitĂˇĹ™e, tajnĂ˝ klĂ­ÄŤ a cesty k testovacĂ­mu serveru.
3. Nainstalujte Git hook:
   SpusĹĄte `scripts/install-hooks.bat`.

### 3. NasazenĂ­ na hosting
1. Nahrajte `deploy.php` do sloĹľky na serveru.
2. V prohlĂ­ĹľeÄŤi otevĹ™ete inicializaÄŤnĂ­ URL:
   `https://jiriklusak.cz/projects/novy-web/deploy.php?secret=VAS_SECRET&branch=design`
