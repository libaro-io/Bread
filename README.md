# Bread

[![Latest Version on Packagist](https://img.shields.io/packagist/v/libaro/bread.svg?style=flat-square)](https://packagist.org/packages/libaro/bread)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/libaro-io/Bread/run-tests?label=tests)](https://github.com/libaro-io/Bread/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/workflow/status/libaro-io/Bread/Check%20&%20fix%20styling?label=code%20style)](https://github.com/libaro-io/Bread/actions?query=workflow%3A"Check+%26+fix+styling"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/libaro/bread.svg?style=flat-square)](https://packagist.org/packages/libaro/bread)


## What is Bread?

Bread stands for Browse, Read, Edit, Add and Delete. It allows the developer to rapidly create CRUD applications, simply
by describing which fields to use.

The full documentation is installed with the package under `/docs`

Bread is a Laravel package to be used in combination with Inertia, Tailwind and Vue. So be sure to have these installed and configured.

## Installation

```bash
composer require libaro/bread
```

## Publish resource files

Run following command to publish the javascript files needed to render the index and form pages.

```bash
php artisan vendor:publish --tag=bread --force
```

This will add the following to your project:

```
/Bread
  /Resources
    /js 
    /ui
```

You can customize the published files and add your own components in the `Bread/Resources` directory.

### Update your inertia app
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

### Add the '@bread' alias to your webpack config file
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




## Dependencies

Bread requires the following dependencies, be sure to install these in your project:

```bash
npm install -D tailwindcss@^3.1 postcss autoprefixer vue@^3.2 @inertiajs/inertia@^0.11.0 @inertiajs/inertia-vue3@^0.6.0 unplugin-vue-define-options@^0.6.1 @tailwindcss/forms@^0.4.0 @headlessui/vue@^1.6 pinia@^2.0.0 uuid@^8.3.2 luxon@^2.4.0
```

```bash
composer require tightenco/ziggy
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](https://github.com/libaro-io/.github/blob/main/CONTRIBUTING.md) for details.

## Development Flow

Please see [DEVELOPMENT FLOW](https://github.com/libaro-io/.github/blob/main/DEVELOPMENT_FLOW.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Libaro](https://github.com/libaro-io)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
