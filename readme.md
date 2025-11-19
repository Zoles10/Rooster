<h1  align="center"> Semestrálne zadanie - I-ASOS 2.roč 3.sem</h1>
<p align="center">Vytvorené počas akademického roku 2025/26 zimný semester.</p> 
<h3 align="center">Vytvorené pomocou</h3>
<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

## Návod na prácu

### Návod na prácu s dockerom a laravel projektom

1. Git clone na WSL2 (linux distro)
2. Otvoriť VSCode/PHPStorm/Vim na WSL a otvoriť projekt (daj ho do /home/user)
3.  `docker-compose build` následne `docker-compose up -d` na zastavenie `docker-compose down`
4. Do terminálu v priečinku projektu napíš `docker exec -it php /bin/sh` pre vstup do php kontajneru
5. Napíš `composer install` prípadne predtým `composer update`
6. Napíš `chmod -R 777 storage` pre udelenie práv php kontajneru
7. Napíš `php artisan migrate:fresh --seed` na naplnenie databázy sample údajmi
8. Napíš `npm run build` v aby si natiahol CSS a JS, prípadne `npm run dev` ak chceš ďalej programovať
9. Vystúp z php kontajneru pomocou `exit`
10. Mal by si mať funkčnú web aplikáciu s dátami

## Autori

-   Martin Vidlička (backend, dokumentácia)
-   Viktor Malý (frontend, dokumentácia)
-   Matúš Petrovaj (backend, testy)
-   Daniel Janík (project lead, fullstack)
-   Zoltán Raffay (frontend, revízia)

## Obsah aplikácie:

### Všeobecné:

-   [x] dvojjazyčnosť
-   [x] responzivita
-   [x] 3 role: neprihlásený, prihlásený a admin
-   [x] príručka exportovateľnná do pdf, čo robí ktorá rola
-   [x] Titulná stránka s prihlásením a zadaním kódu pre anketu/kvíz/otázku

---

### Neprihlásený používateľ:

-   [x] možnosť registrácie
-   [x] zadanie kódu:
    -   [x] na titulnej stránkeň
    -   [x] naskenovaním QR kódu na titulnej strane
    -   [x] do url v tvare ...webte.fei.stuba.sk/kod
-   [x] presmerovanie po zadaní kódu na otázky
-   [x] na stránke s otázkami umožniť návrat na titulnú stránku
-   [x] pri zobrazení výsledkov na otázku, kde je možné odpovedať rôznym textom, vytvoriť word cloud, ktorý vytvoríme **samostatne**, nepoužívať kódy z internetu :skull:!!!
-   [x] velkosť textu v word cloude, na základe počtu rovnakých odpovedí

---

### Prihlásený používateľ:

-   [x] prihlásenie
-   [x] odhlásenie
-   [x] zmena hesla
-   [x] zadefinovanie viacerých hlasovacích otázok
-   [x] definovanie, ktoré otázky sú aktívne a ktoré nie
-   [x] generovanie kódu pre otázku:
    -   [x] textový kód
    -   [x] QR kód z textového kódu
-   [x] otázka:
    -   [x] s možnosťami, kde môže byť správna jedna alebo viac možností
    -   [x] s otvorenou krátkou odpoveďou (text)
-   [x] pri otázke s otvorenou odpoveďou:
    -   [x] výsledok vo forme word cloudu
    -   [x] výsledok vo forme zoznamu
-   [x] existujúca otázka:
    -   [x] úprava
    -   [x] vymazanie
    -   [x] duplikácia
-   [x] ku každej otázke definovať k akému predmetu patrí
-   [x] filtrácia otázok na základe predmetu
-   [x] filtrácia otázok na základe dátumu vytvorenia
-   [x] uzatvorenie hlasovania pre danú otázku
-   [x] pri uzavretí otázky:
    -   [x] uložiť odpovede s dátumom uzavretia
    -   [x] k uzavretiu umožniť vytvoriť poznámku
-   [x] zobrazenie výsledkov aktuálnych a archivovaných hlasovaní
-   [x] pri otázkach s možnosťami zobraziť porovnanie s historickými hlasovaniami (tabuľka)
-   [x] exportovanie otázok a odpovedí do csv, json alebo xml (**dal by som csv**)

---

### Admin:

-   [x] prístup k hlasovacím otázkam všetkých užívateľov
-   [x] možnosť filtrovania nad vybraným užívateľom
-   [x] vytváranie otázky:
    -   [x] v svojom mene
    -   [x] v mene iného užívateľa
-   [x] správa prihlásných užívateľov (**CRUD**)
-   [x] zmena hesla užívateľov
-   [x] zmena role užívateľa
