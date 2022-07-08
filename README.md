# Bread

[![Latest Version on Packagist](https://img.shields.io/packagist/v/libaro/bread.svg?style=flat-square)](https://packagist.org/packages/libaro/bread)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/libaro-io/Bread/run-tests?label=tests)](https://github.com/libaro-io/Bread/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/workflow/status/libaro-io/Bread/Check%20&%20fix%20styling?label=code%20style)](https://github.com/libaro-io/Bread/actions?query=workflow%3A"Check+%26+fix+styling"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/libaro/bread.svg?style=flat-square)](https://packagist.org/packages/libaro/bread)

## Version
Current version is 1.3
Only documentation with `version ~1.3.0` or lower is applicable

## What is Bread? `version ~1.0.0`

Bread stands for Browse, Read, Edit, Add and Delete. It allows the developer to rapidly create CRUD applications, simply
by describing which fields to use.

This document gives general usage documentation. The full documentation is installed
when publishing the resource files.

```bash
composer require libaro/bread
```

## Publish resource files `version ~1.0.0`

Run following command to publish the javascript files needed to render the index and form pages.

`php artisan vendor:publish --tag=bread --force`

This will add the following to your project:

```
/Bread
  /Documentation
  /Resources
    /js 
    /ui
```

You can customize the published files and add your own components in the `Bread/Resources` directory.

### Update your inertia app `version ~1.0.0`
Update your inertia app to include the following:
````javascript
createInertiaApp({
  resolve: (name) => {
    const [domain, path] = name.split('::')

    let page = null

    if (domain === 'Bread') {
      page = require(`./../../../Bread/Resources/ui/Pages/${path}.vue`).default
    } else {
      page = require(`./../../../resources/admin/ui/Pages/${domain}/${path}.vue`).default
    }

    page.layout ??= Backend

    return page
  },
  ...
})
````
This allows the use of `{domain}::{page}` when calling an Inertia Page (e.g.: `Bread::Index`).

### Add the '@bread' alias to your webpack config file `version ~1.0.0`
```javascript
const path = require('path')

module.exports = {
  optimization: {
    minimize: false,
  },
  resolve: {
    alias: {
      '@bread': path.resolve('Bread/Resources')
    }
  }
}
```

## Customizing `version ~1.4.0`

Bread has been designed from the ground up with customization in mind. By default, Bread will look for an
optional `bread.config.js` file at the root of your project where you can define any customizations.

### Creating your config file `version ~1.4.0`

Generate a Bread config by running `php artisan bread:config`
This will create a minimal `bread.config.js` file in your project root.

````js
module.exports = {
  colors: {}
}
````

### Scaffolding the entire default configuration `version ~1.4.0`

For most users we encourage you to keep your config file as minimal as possible, and only specify the things you want to
customize.

If you’d rather scaffold a complete configuration file that includes all of Bread’s default configuration, use the
--full option: `php artisan bread:config --full`

````js
module.exports = {
  colors: {
    primary: 'blue-500',
    secondary: 'grey-500',
  }
}
````

## Dependencies `version ~1.0.0`

Bread requires the following dependencies, be sure to install these in your project:

`npm install -D tailwindcss@^3.1 postcss autoprefixer vue@^3.2
@inertiajs/inertia@^0.11.0 @inertiajs/inertia-vue3@^0.6.0
unplugin-vue-define-options@^0.6.1 @tailwindcss/forms@^0.4.0
@headlessui/vue@^1.6 pinia@^2.0.0 uuid@^8.3.2 luxon@^2.4.0`

`composer require tightenco/ziggy`

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Libaro](https://github.com/libaro-io)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
