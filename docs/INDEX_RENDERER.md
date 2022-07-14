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
