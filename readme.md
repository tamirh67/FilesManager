

#Files Manager

A basic package to upload files in L5, with some examples of how to attach media to any object, list, show gallery of images, etc...

##Installation

Require this package in your `composer.json` and update composer. This will download the package

```php
"tamirh67/filesmanager": "dev-master"
```

After updating composer, add the ServiceProvider to the providers array in `config/app.php`

```php
'tamirh67\FilesManager\FilesManagerServiceProvider',
'Intervention\Image\ImageServiceProvider::class',
```

And add the ServiceProvider to the facades array in `config/app.php`
```php
'Image'     => Intervention\Image\Facades\Image::class,
```

To publish the config settings in Laravel 5 use:

```php
php artisan vendor:publish
```

This will add an `filesmanager.php` config file to your config folder.

## Documentation



## Support

Support only through Github. Please don't mail us about issues, make a Github issue instead.

## Contributing


## License

This package is licensed under MIT. You are free to use it in personal and commercial projects. The code can be forked and modified, but the original copyright author should always be included!
