<h1  align="center"> Semestrálne zadanie - I-ASOS 2.roč 3.sem</h1>
<p align="center">Vytvorené počas akademického roku 2025/26 zimný semester.</p> 
<h3 align="center">Vytvorené pomocou</h3>
<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

## Návod na prácu

### Windows

Silno odporúčame spúšťať cez WSL2. Dá sa spustiť aj čisto na Windowse, ale aplikácia môže byť citeľne pomalšia.

1. Git clone na WSL2 (linux distro)
2. Otvoriť projekt vo VSCode/PHPStorm/Vim (aby ste mali terminál rovno v working directory)
3. `docker-compose build` následne `docker-compose up -d` na zastavenie `docker-compose down`
4. Do terminálu v priečinku projektu napíš `docker exec -it php /bin/sh` pre vstup do php kontajneru
5. Napíš `composer install` prípadne predtým `composer update`
6. Napíš `chmod -R 777 storage` pre udelenie práv php kontajneru
7. Napíš `php artisan migrate:fresh --seed` na naplnenie databázy sample údajmi
8. Napíš `npm install`
9. Napíš `npm run build` v aby si natiahol CSS a JS, prípadne `npm run dev` ak chceš ďalej programovať
10. Vystúp z php kontajneru pomocou `exit`
11. Mal by si mať funkčnú web aplikáciu s dátami na `localhost:8082`

### MacOS

1. Stačí dať clone do Vami zvoleného adresára a pokračovať s krokom 2.

### Linux

1. Stačí dať clone do Vami zvoleného adresára a pokračovať s krokom 2.

## Autori

-   Martin Vidlička (backend, dokumentácia)
-   Viktor Malý (frontend, dokumentácia)
-   Matúš Petrovaj (backend, testy)
-   Daniel Janík (project lead, fullstack)
-   Zoltán Raffay (frontend, revízia)
