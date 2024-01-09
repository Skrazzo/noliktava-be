```sh
composer install
create .env
php artisan migrate
php artisan serve
```

# API Requests

All routes base url is http://localhost:8000/api/

### User management

|route|arguments|why?|method|
|---|---|---|---|
|/login|[username, password]|login user| POST |
|/logout|no arguments| logout of current user|GET|
|/users| [password, username, privilage] | create user, privilage can only be 0, 1, 2 | POST|
|/users|no arguments|see all user information|GET|
|/users/{id}|no arguments| see specific user info based on id|GET|
|/users/{id}|[password, privilage - 0,1,2]|edit specific users password or privilage information|PUT|
|/users/{id}|no arguments| delete specific user based on its id| DELETE|

### Shelves

|route|arguments|why?|method|
|---|---|---|---|
|/shelf|no arguments|print out all shelves|GET|
|/shelf/{id}|no arguments|list one shelfs items|GET|
|/shelf| [name] | create new shelf|POST|
|/shelf/{id}| [name]| update shelfs name| PUT|
|/shelf/{id}| no arguments| delete specified shelf|DELETE|

### Products
|route|arguments|why?|method|
|---|---|---|---|
|/items|no arguments| list all products in the store|GET|
|/items{id}|no arguments| list specified product|GET|
|/items|[shelf_id, name, price, image_url]| create new product|POST|
|/items{id}|[shelf_id, name, price, image_url] (optional)| update already existing product|PUT|
|/items{id}| no arguments| delete product|DELETE|
