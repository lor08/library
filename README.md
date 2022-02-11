Задача: как сейчас
Есть настоящая книжная библиотека.
В настоящее время библиотека представляет собой просто набор книг на полках, и каждая книга помечена штрих-кодом. Библиотекарь-человек будет сканировать каждую книгу с помощью сканера штрих-кода, который достаточно умен, чтобы отправлять отсканированную информацию с помощью HTTP на настроенный адрес. Сканер имеет светодиодный индикатор, который может быть зеленым или красным, который включается на несколько секунд после сканирования, чтобы показать результат сканирования. Цвет светодиода можно настроить так, чтобы он зависел от HTTP-ответа POST/book.
Сканер отправляет следующий HTTP-запрос:
ПОСТ/скан
Тип содержимого: приложение/json
Принять: приложение/json
{"isbn": <int>, "author_full_name": <string>, "title": <string>, "год": <число>}
Иногда сканер не может прочитать все поля данных. В этом случае он все равно отправляет информацию с неправильно прочитанными полями, пустыми или заполненными мусором, никто не знает

Задача - уровень 1
Нам нужно создать простую автоматизацию библиотеки книг реального мира. Это должен быть бэкэнд сервис, который предоставляет API промежуточного программного обеспечения ("Library API"), который наши читатели могут использовать для отслеживания книг нашей библиотеки, некоторые статистические данные и т.д.
Не существует строгого определения подписей в API методах - только описание метода, который должен быть получен и что должно быть в ответ. Вы должны сами создавать подписи API.
Сохранить ввод сканера
Метод принимает запрос, отправленный сканером штрих-кода (см.выше). Следует сохранять только полные и как можно более точные данные (все поля требуются, типы проверяются, год находится в правильном диапазоне и т.д.). Предложите и реализуйте НТТР-ответ, который этот метод вернёт для сканера СИД.
Топ 100 авторов
Метод не принимает никаких параметров. Возвращает 100 наименований, где каждое наименование должно содержать имя автора и количество книг, написанных этим автором, отсортированных по количеству книг в порядке убывания.
Получать книги от автора
Метод принимает имя автора. Следует вернуть все книги, написанные этим автором. Каждый элемент должен содержать хотя бы название книги, ISBN и время добавления в базу данных.


Задача - уровень 2
В дополнение к уровню 1:
Обновить метод "Получить книги от автора" Он должен принять любую часть имени автора ("нечеткий" поиск) и вернуть список совпадающих книг. Каждый возвращаемый элемент должен содержать хотя бы название книги, ISBN и имя автора.
Метод обновления "Сохранить ввод сканера"
Для целей аудита метод должен регистрировать каждую попытку сканирования в какой-либо файл в локальной файловой системе. Регистрационная запись должна содержать все данные, необходимые для проверки того, что сканирование прошло успешно, и причины, если нет.
Новый метод: Получение книг в течение ряда лет
Метод принимает один или два параметра, которые определяют диапазон лет. Параметр года, который не указан, означает -Бесконечность/+Бесконечность. Метод должен возвращать книги из диапазона года. Каждый элемент должен содержать хотя бы название книги, ISBN и имя автора.
Новый метод: получение автором среднего количества книг в год
Следует принять имя автора и вернуть объект JSON, где ключи - годы, каждое значение - это объект, где ключи - имена автора, каждое значение - это плавающее число, обозначающее среднее число книг на автора в год.


Задача - уровень З
В дополнение к уровню 2:
Обновление метода "Получить книги от автора"
Следует также вернуть в каждом элементе URL изображения, содержащего обложку книги. Служба библиотечного API не должна содержать эти изображения, некоторые публичные API могут быть использованы для получения этого URL.
Не только книги
Добавьте новый тип контента, который будет поддерживать Library API - аудио компакт-диски. Все методы могут быть изменены, чтобы сделать это изменение эффективным: URL методов книги не должны совпадать с аудио CD, вероятно, модели должны быть разными и т.д.
Правила проверки, используемые "Сохранить вход сканера" для аудиодисков, отличаются: поскольку аудио компакт-диски не имеют ISBN, правильны только пустые ISBNs для аудио компакт-дисков.

sail artisan migrate:fresh --seed

http://localhost/api/v1/books?start_year=2000&stop_year=2002

````http request
POST /api/search HTTP/1.1
Host: localhost
Accept: application/json
Content-Type: application/json
X-Requested-With: XMLHttpRequest
Cache-Control: no-cache

{ "author_full_name": "Taylor" }
````

````http request
POST /api/scan HTTP/1.1
Host: localhost
Accept: application/json
Content-Type: application/json
X-Requested-With: XMLHttpRequest
Cache-Control: no-cache

{ "isbn": 3444434444444, "author_name": "ivan", "title": "root", "year": 2022 }
````

https://github.com/lucaxue/library-api/blob/main/database/factories/BookFactory.php
https://dberri.com/how-to-create-a-rest-api-with-laravel/
https://blog.pusher.com/build-rest-api-laravel-api-resources/
https://github.com/Melcus/parking-frontend
https://github.com/Melcus/parking-system/blob/main/app/Http/Requests/RegisterFormRequest.php
https://github.com/chelout/laravel-library-test/blob/master/database/factories/BookFactory.php
https://laravel.su/docs/8.x/database-testing#factory-callbacks


<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains over 2000 video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the Laravel [Patreon page](https://patreon.com/taylorotwell).

### Premium Partners

- **[Vehikl](https://vehikl.com/)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Cubet Techno Labs](https://cubettech.com)**
- **[Cyber-Duck](https://cyber-duck.co.uk)**
- **[Many](https://www.many.co.uk)**
- **[Webdock, Fast VPS Hosting](https://www.webdock.io/en)**
- **[DevSquad](https://devsquad.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel/)**
- **[OP.GG](https://op.gg)**
- **[WebReinvent](https://webreinvent.com/?utm_source=laravel&utm_medium=github&utm_campaign=patreon-sponsors)**
- **[Lendio](https://lendio.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
