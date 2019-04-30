# Visual Foxpro ORM for Laravel

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Total Downloads][ico-downloads]][link-downloads]
[![Build Status][ico-travis]][link-travis]

Primitive Visual Foxpro ORM for Laravel

## Installation

Via Composer

``` bash
$ composer require szhorvath/visual-foxpro-orm
```

Add the following environmental variable to your `.env` file

```php
VFP_PROVIDER=VFPOLEDB.1
VFP_SOURCE="//server/database.dbc"
```

You must publish the config file:

```bash
$ php artisan vendor:publish --provider="Szhorvath\\FoxproDB\\FoxproDBServiceProvider"
```

## Usage

## Change log

Please see the [changelog](changelog.md) for more information on what has changed recently.

## Testing

``` bash
$ composer test
```

## Contributing

Please see [contributing.md](contributing.md) for details and a todolist.

## Security

If you discover any security related issues, please email author email instead of using the issue tracker.

## Credits

- [author name][link-author]
- [All Contributors][link-contributors]

## License

license. Please see the [license file](license.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/szhorvath/visualfoxproorm.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/szhorvath/visualfoxproorm.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/szhorvath/visualfoxproorm/master.svg?style=flat-square
[ico-styleci]: https://styleci.io/repos/12345678/shield

[link-packagist]: https://packagist.org/packages/szhorvath/visualfoxproorm
[link-downloads]: https://packagist.org/packages/szhorvath/visualfoxproorm
[link-travis]: https://travis-ci.org/szhorvath/visualfoxproorm
[link-author]: https://github.com/szhorvath
[link-contributors]: ../../contributors
