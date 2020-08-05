## Usage
- Add permissions to shell script chmod +x ./scripts/setup.sh
- Run ./scripts/setup.sh
- OR 
- Clone the repository with `git clone`
- Copy `.env.example` file to `.env` and edit database credentials there
- Run `composer install`
- Run `composer update`
- Run `php artisan key:generate`
- Run `php artisan migrate --seed` (it has some seeded data - see below)
- If error occurs after migration, run `sudo php artisan cache:forget spatie.permission.cache && sudo php artisan cache:clear` to clear permission cache
- Create public/uploads folder add write permissions to `storage, bootstrap and public/uploads` folder
- Launch the main URL and login with default credentials `admin@admin.com` - `123456`
- Setup mail credentials for email sending in .env file
- This boilerplate has one role (`administrator`), 4 permissions (`users_manage`,`ships_manage`,`notification_manage`,`notification_view`) and one administrator user.
- Permissions `users_manage`,`ships_manage`,`notification_manage`

## App Usage
- Login as admin@admin.com/123456
- Add new rank and assign "notification_view" permission to it
- Create new user(crew member) and assign him newly created rank
- Create ship and assign users to it
- Log in as user with different rank and go to dashboard route to see all your notifications
