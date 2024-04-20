<!-- ABOUT THE PROJECT -->
## Features

* [Docker](https://www.docker.com/)
* [Dockerfile with Alpine](https://hub.docker.com/_/alpine)
* [Nginx](https://www.nginx.com)
* [Laravel 11](https://laravel.com/)
* [MySQL](https://www.mysql.com/)
* [PHP 8.2](https://nodejs.org)
* [Node](https://nodejs.org)
* [NPM](https://www.npmjs.com)
* [PHP Prettier](https://github.com/prettier/plugin-php)
* [Github Action To Run Prettier Check](https://github.com/ishaqadhel/docker-laravel-mysql-nginx-starter/actions)
* [Github Action To Run PHP Unit Test](https://github.com/ishaqadhel/docker-laravel-mysql-nginx-starter/actions)

<!-- USAGE EXAMPLES -->
## Run App Manually

![preview-docker-laravel](https://user-images.githubusercontent.com/49280352/131224609-401fcd2b-a815-49f2-8164-b6d9b77df87c.gif)

- Create .env file for the Laravel environment from .env.example on src folder
- Run command ```docker-compose build``` on your terminal
- Run command ```docker-compose up -d``` on your terminal
- Run command ```composer install``` on your terminal after going into the php container on docker
- Run command ```docker exec -it php /bin/sh``` on your terminal
- Run command ```chmod -R 777 storage``` on your terminal after going into the php container on docker
- If app:key still empty on .env run ```php artisan key:generate``` on your terminal after going into the php container on docker
- To run artisan commands like migrate, etc. go to php container using ```docker exec -it php /bin/sh```
- Go to http://localhost:8001 or any port you set to open Laravel

## Notes

- If you encounter a permission error when running Docker, try running it as an administrator or using ```sudo``` in Linux.
- Check the summary of new features in Laravel 11 [here](https://laraveldaily.com/post/laravel-11-main-new-features-changes) or on the official page [here](https://laravel.com/docs/11.x/releases).
- Right now, I will postpone upgrading to PHP 8.3 because the PHP Plugin in Prettier is not supported yet. [Check the issues here](https://github.com/prettier/plugin-php/issues/2299).
- Don't forget to run ```npm run format``` inside your php container or run ```make code-format``` before you push your code.
- Don't forget to run ```php artisan test``` inside your php container or run ```make code-test``` before you push your code.

<!-- MARKDOWN LINKS & IMAGES -->
<!-- https://www.markdownguide.org/basic-syntax/#reference-style-links -->
[contributors-shield]: https://img.shields.io/github/contributors/ishaqadhel/docker-laravel-mysql-nginx-starter.svg?style=for-the-badge
[contributors-url]: https://github.com/ishaqadhel/docker-laravel-mysql-nginx-starter/graphs/contributors
[forks-shield]: https://img.shields.io/github/forks/ishaqadhel/docker-laravel-mysql-nginx-starter.svg?style=for-the-badge
[forks-url]: https://github.com/ishaqadhel/docker-laravel-mysql-nginx-starter/network/members
[stars-shield]: https://img.shields.io/github/stars/ishaqadhel/docker-laravel-mysql-nginx-starter.svg?style=for-the-badge
[stars-url]: https://github.com/ishaqadhel/docker-laravel-mysql-nginx-starter/stargazers
[issues-shield]: https://img.shields.io/github/issues/ishaqadhel/docker-laravel-mysql-nginx-starter.svg?style=for-the-badge
[issues-url]: https://github.com/ishaqadhel/docker-laravel-mysql-nginx-starter/issues
[license-shield]: https://img.shields.io/github/license/ishaqadhel/docker-laravel-mysql-nginx-starter.svg?style=for-the-badge
[license-url]: https://github.com/ishaqadhel/docker-laravel-mysql-nginx-starter/blob/master/LICENSE.txt
[linkedin-shield]: https://img.shields.io/badge/-LinkedIn-black.svg?style=for-the-badge&logo=linkedin&colorB=555
[linkedin-url]: https://linkedin.com/in/linkedin_username
[product-screenshot]: images/screenshot.png
