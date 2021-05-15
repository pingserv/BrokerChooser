<img src="https://brokerchooser.com/images/logo@2x.png" alt="BrokerChooser logo">

## BrokerChooser Senior Backend Developer Homework

The application will be available at <b>http://localhost:8080/</b> 

####Install and build docker container:
```
git clone https://github.com/pingserv/BrokerChooser.git
cd BrokerChooser
docker-compose build
docker-compose up -d
docker-compose exec app composer install
docker-compose exec app chown -R www-data:www-data ./
docker-compose exec app php artisan config:cache
docker-compose exec app php artisan migrate --seed
```

####List challenges:
```
php artisan challenge:list
```

####Start challenges:
```
php artisan challenge:start <challenge>
```

####Stop challenges:
```
php artisan challenge:stop <challenge>
```

####Report challenges:
```
php artisan challenge:report <challenge>
```

### Description
Congratulations on getting to this part of our interview process!

Here you can find a basic Laravel project configured with some extra features.

Your task is to design and implement a basic [A/B testing](https://en.wikipedia.org/wiki/A/B_testing) system.

This application already starts a basic session in the database for visitors and is capable of adding events to these sessions.

Requirements:
- An A/B test has a name and 2 or more variants
- Variants have a name and a targeting ratio. The system decides which variant to select for a given A/B test based on the targeting ratios (compared to each other)
- Example: variant A (targeting ratio: 1), variant B (targeting ratio: 2) - in this case, variant B is 2 times more likely to be selected than variant A 
- An A/B test can be started and stopped, after stopping, it cannot be restarted
- At the same time, more A/B tests can run simultaneously
- When an A/B test is running:
  - new sessions should be assigned to one of the variants of the A/B test
  - the site should behave according to the variant selected
  - the site should behave consistently in a given session, i.e. it should not behave according to variant A at first and then according to variant B later

After implementing the above system, create an A/B test (you can use a migration to start it) and demonstrate the usage of the system by changing some behaviour of the site (that is visible to the visitors) based on the A/B test variant.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains over 1500 video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

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

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
