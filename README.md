php 8+
```
composer install
```
или
```
docker run --rm \
-u "$(id -u):$(id -g)" \
-v $(pwd):/var/www/html \
-w /var/www/html \
laravelsail/php81-composer:latest \
composer install --ignore-platform-reqs
```
Подробнее https://laravel.com/docs/9.x/sail#executing-composer-commands
```
cp .env.sail.example .env
```
```
./vendor/bin/sail up -d
```
или сделать псевдоним 
```
alias sail='[ -f sail ] && bash sail || bash vendor/bin/sail'
```
```
sail up -d
```
```
sail artisan key:generate
```
```
sail artisan migrate:fresh --seed
```
```
sail artisan test
```

http://localhost/api/v1/books?start_year=2000&stop_year=2002

http://localhost/api/v1/books/top_authors

Сканер
````http request
POST /api/books HTTP/1.1
Host: localhost
Accept: application/json
Content-Type: application/json
X-Requested-With: XMLHttpRequest
Cache-Control: no-cache

{ "isbn": 3444434444444, "author_name": "ivan", "title": "root", "year": 2022 }
````

Поиск по автору
````http request
POST /api/books/search HTTP/1.1
Host: localhost
Accept: application/json
Content-Type: application/json
X-Requested-With: XMLHttpRequest
Cache-Control: no-cache

{ "author_name": "Taylor" }
````

Сколько книг написал автор в год
````http request
POST /api/books/count_by_author HTTP/1.1
Host: localhost
Accept: application/json
Content-Type: application/json
X-Requested-With: XMLHttpRequest
Cache-Control: no-cache

{ "author_name": "Taylor" }
````

Лог сканера storage/logs/scanner.log
