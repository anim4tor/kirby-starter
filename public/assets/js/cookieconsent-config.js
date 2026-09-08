import './cookieconsent.umd.js';
CookieConsent.run({
    guiOptions: {
        consentModal: {
            layout: "box wide",
            position: "bottom left",
            equalWeightButtons: true,
            flipButtons: false
        },
        preferencesModal: {
            layout: "box",
            position: "right",
            equalWeightButtons: true,
            flipButtons: false
        }
    },
    categories: {
        necessary: {
            readOnly: true
        },
        functionality: {},
        analytics: {},
        marketing: {}
    },
    language: {
        default: "cs",
        autoDetect: "browser",
        translations: {
            cs: {

                consentModal: {
                    title: "Používáme cookies!",
                    description: "Na našich webových stránkách používáme soubory cookies. Některé z nich jsou nezbytné, zatímco jiné nám pomáhají vylepšit tento web a váš uživatelský zážitek.",
                    acceptAllBtn: "Přijmout vše",
                    acceptNecessaryBtn: "Odmítnout vše",
                    showPreferencesBtn: "Přizpůsobit",
                    // footer: "<a href=\"#link\">Privacy Policy</a>\n<a href=\"#link\">Terms and conditions</a>"
                },
                preferencesModal: {
                    title: "Nastavení cookies",
                    acceptAllBtn: "Povolit všechny cookies",
                    acceptNecessaryBtn: "Povolit nezbytné cookies",
                    savePreferencesBtn: "Uložit nastavení",
                    closeIconLabel: "Zavřít okno",
                    serviceCounterLabel: "Service|Services",
                    sections: [
                        {
                            title: "Použití cookies",
                            description: "Soubory cookie používáme k zajištění základních funkcí webu a ke zlepšení vašeho uživatelského zážitku. Souhlas pro každou kategorii můžete kdykoliv změnit."
                        },
                        {
                            title: "Nezbytně nutné soubory cookies <span class=\"pm__badge\">Vždy povoleno</span>",
                            description: "Tyto soubory cookie jsou nezbytné pro správné fungování našich webových stránek. Bez těchto souborů cookie by webové stránky nefungovaly správně.",
                            linkedCategory: "necessary"
                        },
                        {
                            title: "Bezpečnostní cookies",
                            description: "Bezpečnostní soubory cookie umožňují ukládání informací souvisejících se zabezpečením, např. ověřování, ochrana před podvody a další prostředky na ochranu uživatele.",
                            linkedCategory: "functionality"
                        },
                        {
                            title: "Personalizační cookies",
                            description: "Personalizační soubory cookie mohou používat soubory cookie třetích stran, které jim pomáhají přizpůsobit obsah a umožňují sledovat uživatele na různých webových stránkách a zařízeních.",
                            linkedCategory: "functionality"
                        },
                        {
                            title: "Analytické cookies",
                            description: "Analytické cookies nám umožňují měření výkonu našeho webu a našich reklamních kampaní. Jejich pomocí určujeme počet návštěv a zdroje návštěv našich internetových stránek. Data získaná pomocí těchto cookies zpracováváme souhrnně, bez použití identifikátorů, které ukazují na konkrétní uživatelé našeho webu. Pokud vypnete používání analytických cookies ve vztahu k Vaší návštěvě, ztrácíme možnost analýzy výkonu a optimalizace našich opatření.",
                            linkedCategory: "analytics"
                        },
                        {
                            title: "Reklamní cookies",
                            description: "Reklamní cookies používáme my nebo naši partneři, abychom Vám mohli zobrazit vhodné obsahy nebo reklamy jak na našich stránkách, tak na stránkách třetích subjektů. Díky tomu můžeme vytvářet profily založené na Vašich zájmech, tak zvané pseudonymizované profily. Na základě těchto informací není zpravidla možná bezprostřední identifikace Vaší osoby, protože jsou používány pouze pseudonymizované údaje. Pokud nevyjádříte souhlas, nebudete příjemcem obsahů a reklam přizpůsobených Vašim zájmům.",
                            linkedCategory: "marketing"
                        },
                        {
                            title: "Více informací",
                            description: "Máte-li jakékoli dotazy týkající se používání souborů cookie a vašich voleb, kontaktujte nás prosím. <a href=\"https://napisek.cz/ochrana-udaju\">Ochrana osobních údajů</a>"
                        }
                    ]
                }
            }
        }
    }
});
