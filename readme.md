# Skúškové zadanie - B-WEBTE2 3.roč 6.sem

Robené počas akademického roku 2023/24 letný semester

## Návod na prácu

### Predtým ako začneš

1. `sudo apt update && sudo apt -y upgrade`
2. `sudo add-apt-repository ppa:ondrej/php`
3. `sudo apt update && sudo apt -y upgrade`
4. `sudo apt install php-fpm`

### Návod na prácu s dockerom a laravel projektom

1. Git clone na WSL2
2. Otvoriť VSCode na WSL a otvoriť projekt (daj ho do /home/user)
3. Otvoriť terminal a vnoriť sa do cd src/
4. Napíš `composer install`
5. Choď späť pomocou cd ..
6. `docker-compose build` následne `docker-compose up -d` na zastavenie `docker-compose down`
7. <b>VEĽMI PODSTATNÉ (TAKMER SOM TO STRATIL)</b> ideš `docker exec -it php /bin/sh` a napíšeš `chmod -R 777 storage` a vystúpiš z php containeru pomocou `exit`
8. Pre aktualizovanie laravelu cez artisan použi `docker exec -it php /bin/sh` (napojenie sa do terminalu containeru PHP)
9. `php artisan {PRIKAZ}` v PHP containeri keď niečo chceš robiť s laravelom
10. `exit` na opustenie PHP container terminalu

## Autori

-   Matej Ištok (frontend)
-   Jakub Hubáček (frontend)
-   Daniel Janík (backend)
-   Michal Gregorovič (backend)


## Téma

## TODO:

### Všeobecné:

-   [ ] dvojjazyčnosť
-   [ ] responzivita
-   [x] 3 role: neprihlásený, prihlásený a admin
-   [x] príručka exportovateľnná do pdf, čo robí ktorá rola
-   [ ] videoprezentácia
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
-   [ ] pri zobrazení výsledkov na otázku, kde je možné odpovedať rôznym textom, vytvoriť word cloud, ktorý vytvoríme **samostatne**, nepoužívať kódy z internetu :skull:!!!
-   [ ] velkosť textu v word cloude, na základe počtu rovnakých odpovedí

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
-   [ ] pri otázke s otvorenou odpoveďou:
    -   [ ] výsledok vo forme word cloudu
    -   [ ] výsledok vo forme zoznamu
-   [ ] existujúca otázka:
    -   [ ] úprava
    -   [x] vymazanie
    -   [x] duplikácia
-   [x] ku každej otázke definovať k akému predmetu patrí
-   [x] filtrácia otázok na základe predmetu
-   [x] filtrácia otázok na základe dátumu vytvorenia
-   [ ] uzatvorenie hlasovania pre danú otázku
-   [ ] pri uzavretí otázky:
    -   [ ] uložiť odpovede s dátumom uzavretia
    -   [ ] k uzavretiu umožniť vytvoriť poznámku
-   [ ] zobrazenie výsledkov aktuálnych a archivovaných hlasovaní
-   [ ] pri otázkach s možnosťami zobraziť porovnanie s historickými hlasovaniami (tabuľka)
-   [ ] exportovanie otázok a odpovedí do csv, json alebo xml (**dal by som csv**)

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
