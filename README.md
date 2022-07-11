# Bread

[![Latest Version on Packagist](https://img.shields.io/packagist/v/libaro/bread.svg?style=flat-square)](https://packagist.org/packages/libaro/bread)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/libaro-io/Bread/run-tests?label=tests)](https://github.com/libaro-io/Bread/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/workflow/status/libaro-io/Bread/Check%20&%20fix%20styling?label=code%20style)](https://github.com/libaro-io/Bread/actions?query=workflow%3A"Check+%26+fix+styling"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/libaro/bread.svg?style=flat-square)](https://packagist.org/packages/libaro/bread)


## What is Bread?

Bread stands for Browse, Read, Edit, Add and Delete. It allows the developer to rapidly create CRUD applications, simply
by describing which fields to use.

This document gives general usage documentation. The full documentation is installed
when publishing the resource files.

## Installation

```bash
composer require libaro/bread
```

## Publish resource files

Run following command to publish the javascript files needed to render the index and form pages.

`php artisan vendor:publish --tag=bread --force`

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

## Customizing the styling

Bread has been designed from the ground up with customization in mind. You can change the styling of certain elements by
changing them in `Bread/Resources/js/style_config.js`.

Bread uses TailwindCSS classes to build its layout. You can override the styling of Bread components and colors by
providing it your own tailwind classes.

If you want to use the styles from `style_config.js` in your own components. Simply import the `Bread` service class from
`@bread/js/Services/Bread`.

```html
<div :class="Bread.style('buttons.danger')>
  My Custom Component
</div>
```

You can change the styles in `Bread/Resources/js/style_config.js`. 
`@bread(key)` is a reference to a key in the style_config file, and will be replaced with those classes by the
`Bread.style()` service. 

````javascript
export default {
  text: {
    light: 'text-gray-50 hover:text-gray-100',
    dark: 'text-gray-700 hover:text-gray-800',
    success: 'text-green-600 hover:text-green-700',
    danger: 'text-red-600 hover:text-red-700',
    info: 'text-yellow-600 hover:text-yellow-700',
    new: 'text-blue-600 hover:text-blue-700',
  },
  colors: {
    light: 'bg-white hover:bg-gray-50 text-gray-700',
    dark: 'bg-gray-700 hover:bg-gray-500 text-white',
    success: 'bg-green-600 hover:bg-green-700 text-white',
    danger: 'bg-red-600 hover:bg-red-700 text-white',
    info: 'bg-yellow-600 hover:bg-yellow-700 text-white',
    new: 'bg-blue-600 hover:bg-blue-700 text-white',
  },
  rings: {
    base: 'focus:outline-none focus:ring-2 focus:ring-offset-2',
    light: '@bread(rings.base) focus:ring-gray-200 ',
    dark: '@bread(rings.base) focus:ring-gray-500 ',
    success: '@bread(rings.base) focus:ring-green-500 ',
    danger: '@bread(rings.base) focus:ring-red-500 ',
    info: '@bread(rings.base) focus:ring-yellow-500 ',
    new: '@bread(rings.base) focus:ring-blue-500 ',
  },
  buttons: {
    base: 'inline-flex w-full justify-center rounded-md border border-transparent px-4 py-2 text-base font-medium text-white shadow-sm sm:col-start-2 sm:text-sm',
    light:
      '@bread(buttons.base) @bread(colors.light) @bread(rings.light) border-gray-100',
    dark: '@bread(buttons.base) @bread(colors.dark) @bread(rings.dark)',
    success:
      '@bread(buttons.base) @bread(colors.success) @bread(rings.success)',
    danger: '@bread(buttons.base) @bread(colors.danger) @bread(rings.danger)',
    info: '@bread(buttons.base) @bread(colors.info) @bread(rings.info)',
    new: '@bread(buttons.base) @bread(colors.new) @bread(rings.new)',
  },
}
````


## Dependencies

Bread requires the following dependencies, be sure to install these in your project:

`npm install -D tailwindcss@^3.1 postcss autoprefixer vue@^3.2
@inertiajs/inertia@^0.11.0 @inertiajs/inertia-vue3@^0.6.0
unplugin-vue-define-options@^0.6.1 @tailwindcss/forms@^0.4.0
@headlessui/vue@^1.6 pinia@^2.0.0 uuid@^8.3.2 luxon@^2.4.0`

`composer require tightenco/ziggy`

# Index Renderer

## What is it?

The Index Renderer allows you to render an index page. Simply provide it the headers and data to render, and it will do
the rest. You can even optionally provide filters to apply to the data.

## Example

````php
namespace App\Domains\Users\Controllers;

final class UserController
{
   $filters = UserFilters::make();

   public function index() {
        return IndexRenderer::render()
            ->title('Users')
            ->headers(UserIndexHeaders::class)
            ->routes(UserRoutes::class);
            ->filters($filters)
            ->items($this->getData($filters));
   }
   
   protected function getData($filters) {
        return Product::query()->filter($filters)->get();
   }
}
````

````php
namespace App\Domains\Users\Bread;

use Libaro\Bread\Headers\Text;
use Libaro\Bread\Headers\Label;
use Libaro\Bread\Headers\Number;
use Libaro\Bread\Headers\Boolean;
use Libaro\Bread\Headers\Headers;
use Libaro\Bread\Contracts\Renderer;
use Libaro\Bread\Contracts\Invokables;

final class UserIndexHeader implements Invokables
{
   protected function __invoke(Renderer $renderer) {
        return Headers::add(
            Text::make('Name', 'name')->sortable(),
            Text::make('Email', 'email')->sortable(),
            Number::make('Age', 'age')->sortable(),
            Boolean::make('Active', 'active')->sortable()->editable(),
            Label::make('Role', 'user.role')->sortable()
        );
   }
}
````

````php
namespace App\Domains\Users\Bread;

use Libaro\Bread\Filters\Text;
use Libaro\Bread\Filters\Select;
use Libaro\Bread\Filters\Number;
use Libaro\Bread\Filters\Filters;
use Libaro\Bread\Filters\Boolean;

final class UserFilter
{
    public static function make()
    {
        return (new self())();
    }
    
   protected function __invoke(): Filters 
   {
        return Filters::add(
            Text::make('Name', 'name'),
            Text::make('Email', 'email'),
            Number::make('Age', 'age'),
            Boolean::make('Active', 'active'),
            Select::make('Role', 'user.role')->options([
                'admin' => 'Admin',
                'user' => 'User',
            ])
            Boolean::make('Is Nieuw', 'is_new')->isNew(),
        )->sideBarStarsAt(5);
   }
}
````

## Headers
We have provided a number of headers that you can use.
All headers have a range of options that you can use to customize the header.

### Available Headers
- `Text`
- `Number`
- `Boolean`
- `Label`
- `Date`
- `Trend`
- `Download`
- `InertiaLink`
- `Link`
- `Rating`
- `Set`
- `Money`

### Creating custom headers
You can also create your own header.

### Manually
- Create a php class which extends the
  `Libaro\Bread\Contracts\Header` class.
- Create a vue component in `Bread/Resources/ui/Components/Table/Fields`.

#### With Bread command
Run `php artisan bread:header NameOfYourHeader` to create a new header.

Two files will be created:
- `Bread/Headers/NameOfYourHeader.php`
- `Bread/Resources/ui/Components/Table/Fields/NameOfYourHeader.vue`

This header will automagically be recognized by Bread.

### Options
You provide options using a fluent api, which means you can chain them in any order.
- `sortable`
- `editable`
- `label`
- `placeholder`

## Filters
We have provided a number of filters that you can use. You can also create your own filters by
extending the `Filter` class.

### Available Filters
- `Text`
- `Select`
- `Boolean`

### Options
You can provide a custom filter query to use. Simply chain it to the filter.

````php
Boolean::make('Is New', 'is_new')->isNew(),
````

Then in your model add a public method that returns the query. Prefix the method name
with `filter`

````php
namespace Domains\Users\Models;

final class User extends Model
{
...

    /**
    * @param $query: The query to filter and to return
    * @param null $value: The current value of the filter
    * @param array $params: The parameters of the filter (? Jens what are these params?)
    **/ 
    public function filterIsNew($query, $value = null, array $params = [])
    {
        // Return you custom query here
    }
}
````

### Display of filters
Filters can be rendered in two ways. They can be rendered inline just above the table, or they can be rendered
in a slide-out panel. By default, the filters are rendered inline when you provide less than 5 filters.
You can change this by setting the number of filters to display inline.
````php
Filters::add(
    ... your filters ...
)->sideBarStarsAt(5);
````

### Creating your own filter
You can also create your own Filter

### Manually
- Create a php class which extends the `Libaro\Bread\Filters\Filter` class.
- Create a vue component in `Bread/Resources/ui/Components/Filter/Types`.

#### With Bread command
Run `php artisan bread:filter NameOfYourFilter` to create a new filter.

Two files will be created:
- `Bread/Filters/Custom/NameOfYourFilter.php`
- `Bread/Resources/ui/Components/Filter/Types/NameOfYourFilter.vue`

You must add your filter to the fields vue component in `Bread/Resources/ui/Components/Filter/Fields`.
So that it can be loaded by vue. This must also be done when creating filters using the bread command.

# Form Renderer

## What is it?

The Form Renderer allows you to render a form. Simply provide it the fields to render, and it will do the rest.

## Example

```php
namespace App\Domains\Users\Controllers;

use Bread\Routes\UserRoutes;
use Bread\Fields\UserFields;
use Bread\Components\UserFormComponents;

final class UserController
{
    public function create()
    {
        return FormRenderer::render()
            ->title('Create New User')
            ->fields(UserFields::class)
            ->components(UserFormComponents::class) // Optionally render custom components
            ->routes(UserRoutes::class);
    }
}
```

````php
namespace App\Domains\Users\Bread;

use Libaro\Bread\Fields\Text;
use Libaro\Bread\Fields\Fields;
use Libaro\Bread\Fields\Number;
use Libaro\Bread\Fields\Boolean;
use Libaro\Bread\Contracts\Renderer;
use Libaro\Bread\Contracts\Invokables;

final class UserFields implements Invokables
{
   protected function __invoke(Renderer $renderer) {
        return Fields::add(
            Text::make('Name', 'name')
                ->readOnly(),
                
            Text::make('Email', 'email')
                
            Number::make('Age', 'age'),
            
            Boolean::make('Active', 'active'),
            
            Select::make('Role', 'user.role')->options([
                'admin' => 'Admin',
                'user' => 'User',
            ]),
        );
   }
}
````

## Fields

We have provided a number of fields that you can use. You can also create your own field by extending the `Field` class.
All fields have a range of options that you can use to customize the field.

### Available Fields

- `Text`
- `Number`
- `Boolean`
- `Select`
- `Image`

### Options

You provide options using a fluent api, which means you can chain them in any order.

- `readOnly`
- `addWrapperClass`

### Tabs

You can divide you form in tabs and specify which fields to show for each tab.

```php
use Libaro\Bread\Fields\Tab;
use Libaro\Bread\Fields\Tabs;

return Fields::add(
    Tabs::add(
        Tab::make('Kenmerken',
            Text::make('name', 'Naam')
                ->addWrapperClass($class, true),

            BarMultiSelect::make('bars', 'Bars', $bars)
                ->addWrapperClass($class, true)
        ),
    ),
);
```

### Creating your own Field
You can create your own custom Field

## Manually
- Create a php class which extends the
  `Libaro\Bread\Contracts\Field` class.
- Create a vue component in `Bread/Resources/ui/Components/Form/Fields`.

### Using the Bread command
Run `php artisan bread:field NameOfYourField` to create a new field.

Two files will be created:
- `Bread/Fields/Custom/NameOfYourField.php`
- `Bread/Resources/ui/Components/Form/Fields/NameOfYourField.vue`

This field will automagically be recognized by Bread.


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
