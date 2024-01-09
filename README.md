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
|/users/{id}|no arguments| see specific user info based on id|GET|
|/users/{id}|[password, privilage - 0,1,2]|edit specific users password or privilage information|PUT|
|/users/{id}|no arguments| delete specific user based on its id| DELETE|
