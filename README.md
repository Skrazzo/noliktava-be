```sh
composer install
create .env
php artisan migrate
php artisan serve
```

# API Requests

All routes base url is http://localhost:8000/api/

|route|arguments|why?|method|
|---|---|---|---|
|/login|[username, password]|login user| POST |
|/logout|no arguments| logout of current user|GET|
|/users| [password, username, privilage] | create user, privilage can only be 0, 1, 2 | POST|
|/users|no arguments|see all user information|GET|
