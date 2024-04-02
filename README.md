# Skúškové zadanie - B-WEBTE2 3.roč 6.sem
Robené počas akademického roku 2023/24 letný semester
## Autori
- Matej Ištok (frontend)
- Daniel Janík (backend)
- Michal Gregorovič (backend)
- Jakub Hubáček (fullstack)
## Téma

## TODO:

---

# Všeobecné:

- [ ] dvojjazyčnosť
- [ ] responzivita
- [ ] 3 role: neprihlásený, prihlásený a admin
- [ ] príručka exportovateľnná do pdf, čo robí ktorá rola
- [ ] videoprezentácia
- [ ] Titulná stránka s prihlásením a zadaním kódu pre anketu/kvíz/otázku

---

# Neprihlásený používateľ:

- [ ] možnosť registrácie
- [ ] načítanie stránky na základe QR kódu
- [ ] zadanie kódu na titulnej stránke
- [ ] zadanie kódu do url v tvare ...webte.fei.stuba.sk/kod 
- [ ] presmerovanie po zadaní kódu na otázky
- [ ] na stránke s otázkami umožniť návrat na titulnú stránku
- [ ] pri zobrazení výsledkov na otázku, kde je možné odpovedať rôznym textom, vytvoriť word cloud, ktorý vytvoríme **samostatne**, nepoužívať kódy z internetu :skull:!!!
- [ ] velkosť textu v word cloude, na základe počtu rovnakých odpovedí

---

# Prihlásený používateľ:

- [ ] prihlásenie
- [ ] odhlásenie
- [ ] zmena hesla
- [ ] zadefinovanie viacerých hlasovacích otázok
- [ ] definovanie, ktoré otázky sú aktívne a ktoré nie
- [ ] generovanie kódu pre otázku
- [ ] generovanie QR kódu z textového kódu
- [ ] otázka s možnosťami, kde môže byť správna jedna alebo viac možností
- [ ] otázka s otvorenou krátkou odpoveďou (text)
- [ ] pri otázke s otvorenou odpoveďou, rozhodnúť ako sa zobrazuje výsledok word cloud/zoznam
- [ ] úprava existujúcej otázky
- [ ] vymazanie existujúcej otázky
- [ ] duplikácia existujúcej otázky
- [ ] ku každej otázke definovať k akému predmetu patrí
- [ ] filtrácia otázok na základe predmetu
- [ ] filtrácia otázok na základe dátumu vytvorenia
- [ ] uzatvorenie hlasovania pre danú otázku
- [ ] pri uzavretí otázky uložiť odpovede s dátumom uzavretia
- [ ] pri uzavretí otázky k uzavretiu umožniť vytvoriť poznámku
- [ ] zobrazenie výsledkov aktuálnych a archivovaných hlasovaní 
- [ ] pri otázkach s možnosťami zobraziť porovnanie s historickými hlasovaniami (tabuľka)
- [ ] exportovanie otázok a odpovedí do csv, json alebo xml (**dal by som csv**)

---

# Admin:

- [ ] prístup k hlasovacím otázkam všetkých užívateľov
- [ ] možnosť filtrovania nad vybraným užívateľom
- [ ] vytváranie otázky v svojom mene
- [ ] vytváranie otázky v mene iného užívateľa
- [ ] správa prihlásných užívateľov (**CRUD**)
- [ ] zmena hesla užívateľov
- [ ] zmena role užívateľa