# Form Renderer

## What is it? `version ~1.0.0`

The Form Renderer allows you to render a form. Simply provide it the fields to render, and it will do the rest.

## Example `version ~1.0.0`

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

## Fields `version ~1.0.0`

We have provided a number of fields that you can use. You can also create your own field by extending the `Field` class.
All fields have a range of options that you can use to customize the field.

### Available Fields

- `Text`
- `Number`
- `Boolean`
- `Select`
- `Image`

### Options `version ~1.0.0`

You provide options using a fluent api, which means you can chain them in any order.

- `readOnly`
- `addWrapperClass`

### Tabs `version ~1.0.0`

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

## Manually `version ~1.0.0`
- Create a php class which extends the
  `Libaro\Bread\Contracts\Field` class.
- Create a vue component in `Bread/Resources/ui/Components/Form/Fields`.

### Using the Bread command `version ~1.1.0`
Run `php artisan bread:field --name=NameOfYourField` to create a new field. The field will be created
in `Bread/Fields/NameOfYourField/`.
Two files will be created:
- `NameOfYourField.php`
- `NameOfYourField.vue`

All fields in this directory are automatically available to you.
