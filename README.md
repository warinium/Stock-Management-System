<p align="center">
    <h1 align="center">Stock Management System Using Laravel (And React)</h1>
</p>

## Installation

### Requirements

For system requirements you [Check Laravel Requirement](https://laravel.com/docs/10.x/deployment#server-requirements)

### Clone the repository from github.

1. `git clone https://github.com/warinium/Stock-Management-System.git`

2. `cd Stock-Management-System`

3. Create your database.

4. Rename or copy `.env.example` file to `.env`

5. `php artisan key:generate` to generate app key.

6. Set your database credentials in your `.env` file.

7. Set your `APP_URL` in your `.env` file (exemple: `APP_URL=http://127.0.0.1:8000`)

8. Laravel utilizes [Composer](https://getcomposer.org/) to manage its dependencies. So, before using Laravel, make sure you have Composer installed on your machine.

    `composer install`

9. Migrate database table: `php artisan migrate`

10. `php artisan db:seed`, this will initialize settings and create and admin user for you [email: admin@admin.com - password: admin@admin.com].

11. `npm install` to install node dependencies.

12. `npm run dev` for development or `npm run build` for production.

13. `php artisan storage:link`

14. `php artisan serve`

15. Visit `localhost:8000` in your browser.
    Default credentials: Email: `admin@admin.com`, Password: `admin@admin.com`.

### Screenshots

#### Pos

![Pos](https://github.com/warinium/Stock-Management-System/blob/main/screenShots/Pos.png?raw=true)

#### DashBoard

![DashBoard](https://github.com/warinium/Stock-Management-System/blob/main/screenShots/DashBoard.png?raw=true)

#### Products List

![Products List](https://github.com/warinium/Stock-Management-System/blob/main/screenShots/Product-list.png?raw=true)

#### Order list

![Order list](https://github.com/warinium/Stock-Management-System/blob/main/screenShots/Order-List.png?raw=true)

#### Customer list

![Customer list](https://github.com/warinium/Stock-Management-System/blob/main/screenShots/Customer-list.png?raw=true)

[!["Buy Me A Coffee"](https://www.buymeacoffee.com/assets/img/custom_images/orange_img.png)](https://www.buymeacoffee.com/houari)
