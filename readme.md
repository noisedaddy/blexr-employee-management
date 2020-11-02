## Install
- Clone the repository with `git clone`
- Copy `.env.example` file to `.env` 
- Create database and add that name in the .env file
- Setup MAIL credentials to be able to receive mails 
- Run `composer install`
- Run `composer update`
- Run `php artisan key:generate`
- Run `php artisan migrate --seed` (it has some seeded data - see below)
- If error occurs after migration, run `sudo php artisan cache:forget spatie.permission.cache && sudo php artisan cache:clear` to clear permission cache
- Launch the main URL and login with default credentials `admin@admin.com` - `123456`
- Run `sudo chmod -R 777 storage/` for permission rights to storage folder
- Run `sudo chmod -R 777 bootstrap/` for write permission rights to bootstrap folder

## App Usage
- Login as admin@admin.com/123456
- Add new User and assign `"employee"` role to him/her
- New user will receive email with confirmation link which takes him/her to the landing page where he can log in. 
- Log in as new user in different browser and go to the `Requests` sidebar to be able to send work-from-home requests
- Go to the `Requests` sidebar logged as `admin` and `Approve/Reject` requests 
- This boilerplate has two roles (`administrator` and `employee`) with 3 permissions (`users_manage`,`notification_manage`,`notification_view`);
