#Description
- PHP 7.4, Mysql 8, Laravel, Bootstrap, jquery, javascript jquery.Datatables
- Used `spatie permission` package for roles/permissions
- Used ajax `setInterval()` and jquery `Datatables` to be able to simulate real time notifications when requests arrive on the web page.
- Customized Laravel Auth package for user authentication

#app Structure
- Models: `Notification.php`, `User.php`
- Controllers: `app/Http/Controllers/Admin`, `app/Http/Controllers/HomeController.php`
- Views: resources/views
- Helper class for data formatting: `app/Helpers/DataFormat`;
- Mail: `app/Jobs`, `app/Mail`
- Mysql Schema, migrations and data seeders:  `database/migrations/`,`database/seeds`
- Setup sh: scripts/setup.sh
- Routes: routes/web.php

## Install
- Clone the repository with `git clone`
- Copy `.env.example` file to `.env` 
- Create database and add that name in the .env file
- Setup MAIL credentials to be able to receive mails 
- Run `composer install`
- Run `composer update`
- Run `php artisan key:generate`
- Run `php artisan migrate:fresh --seed` (it has some seeded data - see below)
- If error `(A `` permission already exists for guard web)` occurs after migration, run `sudo php artisan cache:forget spatie.permission.cache && sudo php artisan cache:clear` to clear permission cache
- Launch the main URL and login with default credentials `admin@admin.com` - `123456`
- Run `sudo chmod -R 777 storage/` for permission rights to storage folder
- Run `sudo chmod -R 777 bootstrap/` for write permission rights to bootstrap folder
OR
- Add permissions to shell script `chmod +x ./scripts/setup.sh`
- Run `./scripts/setup.sh`

## App Usage
- Login as admin@admin.com/123456
- Add new User and assign `"employee"` role to him/her
- New user will receive email with confirmation link which takes him/her to the landing page where he can log in. 
- Log in as a new user in a different browser and go to the `Requests` sidebar to be able to send work-from-home requests
- Go to the `Requests` sidebar logged as `admin` and `Approve/Reject` requests 
- When selecting a time from a given date using bootstrap datetimepickers, the Start time must be smaller than the End time. Other case alert will pop up with a warning.
- This boilerplate has two roles (`administrator` and `employee`) with 3 permissions (`users_manage`,`notification_manage`,`notification_view`);
