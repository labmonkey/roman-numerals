![Screenshot](/screenshot.jpg?raw=true "Screenshot")

# Roman numerals converter

The purpose of this application was to create a simple project based on Laravel framework (PHP). This project is using all the basic and well known features of Laravel framework as well as MVC principles including:

- Developed using [Homestead](https://laravel.com/docs/5.2/homestead) in Vagrant
- Blade template engine
- The [Laravel Collective](https://laravelcollective.com/docs/5.2/htm) component library
- Eloquent ORM
- Laravel Validator. Used both as built-in in Controllers and as standalone in custom Class
- All custom code contains comments
- Usage of Controllers
- Usage of Routes
- Usage of Interfaces
- Includes PHPUnit tests. Placed in `tests/ConverterTest.php` and run by typing `vendor/bin/phpunit`
- Project structure was made using Laravel installer

### Use Case

- When submitted the form should display both the integer and roman numeral
  values
- Support numbers between 0 and 3999, only numeric characters
- Display history of converted numbers along with creation time