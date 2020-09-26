# A Laravel Nova filter that renders into clickable pills.

A simple Laravel Nova filter that renders into colorful clickable pills. This filter is very inspired by [this other package](https://github.com/dcasia/nova-pill-filter), however we needed some extra features (like customizing the color of each pill) for client projects and that package seemed to not be maintained nor production ready, so we decided to make our own version of this filter.

![Pill Filter](https://raw.githubusercontent.com/Eolica-Web/nova-pill-filter/master/docs/screenshots/screenshot_1.png)

## Installation

You can install the package in to a Laravel app that uses [Nova](https://nova.laravel.com) via composer:

``` bash
composer require eolica/nova-pill-filter
```

## Usage

### Creating the filter

You may create a new pill filter manually and extending the `Eolica\NovaPillFilter\PillFilter` class:

``` php
namespace App\Nova\Filters;

use Illuminate\Http\Request;
use Eolica\NovaPillFilter\PillFilter;

final class MyPillFilter extends PillFilter
{
    public function apply(Request $request, $query, $value)
    {
        return $query;
    }

    public function options(Request $request)
    {
        return [];
    }
}
```

Or, even easier, using the following artisan command:

``` bash
php artisan nova:pill-filter MyPillFilter
```

If you want to customize the "stub" the command uses to generate the filter class, you may use the following command to publish it:

``` bash
php artisan nova:pill-filter-stubs
```

Next, we must register the filter within the `filters` method of our resource:

``` php
final class MyNovaResource extends Resource {

    public function filters(Request $request)
    {
        return [
            Filters\MyPillFilter::make(),
        ];
    }
}
```

### Configuring the filter

By default multiple items can be selected, you can restrict it to a single item at time by using the `single` method

``` php
final class MyNovaResource extends Resource {

    public function filters(Request $request)
    {
        return [
            Filters\MyPillFilter::make()->single(),
        ];
    }
}
```

Also, the filter shows by default a "Clear" button when some item is active. When clicked, deactivates all items at once. If you want to hide the button you may use the `hideClearButton` method:

``` php
final class MyNovaResource extends Resource {

    public function filters(Request $request)
    {
        return [
            Filters\MyPillFilter::make()->hideClearButton(),
        ];
    }
}
```

If you want the "Clear" button to show, you may also change the text within by using the `clearLabel` method, mainly for translation purposes:

``` php
final class MyNovaResource extends Resource {

    public function filters(Request $request)
    {
        return [
            Filters\MyPillFilter::make()->clearLabel('Custom label'),
        ];
    }
}
```

Last, you may change the displaying mode of the filter, by default it wraps to show all pills at once, however you may change it to drag mode by using the `draggable` method:

``` php
final class MyNovaResource extends Resource {

    public function filters(Request $request)
    {
        return [
            Filters\MyPillFilter::make()->draggable(),
        ];
    }
}
```

![Pill Filter](https://raw.githubusercontent.com/Eolica-Web/nova-pill-filter/master/docs/screenshots/screenshot_2.png)

### Configuring the filter options

The most simple way is to return a key/value pair array, the key being the label displayed within the pill:

``` php
final class MyPillFilter extends PillFilter
{
    public function options(Request $request)
    {
        return [
            'Family'        => 'family',
            'Sea'           => 'sea',
            'Sports'        => 'sports',
            'City'          => 'city',
            'Eco'           => 'eco',
            'Countryside'   => 'countryside',
        ];
    }
}
```

You may customize each pill background color, text color, background color when active and text color when active, in this case the key of each option must be the value and the label text must be within the `label` key:

``` php
final class MyPillFilter extends PillFilter
{
    public function options(Request $request)
    {
        return [
            'family' => [
                'label'                 => 'Family',
                'color'                 => '#d53f8c', // Default '#3c4b5f'
                'backgroundColor'       => '#fbb6ce', // Default '#eef1f4'
                'colorActive'           => '#ffffff', // Default '#ffffff'
                'backgroundColorActive' => '#d53f8c', // Default '#4099de'
            ],
            'sea' => [
                'label'                 => 'Sea',
                'color'                 => '#3182ce',
                'backgroundColor'       => '#bee3f8',
                'colorActive'           => '#ffffff',
                'backgroundColorActive' => '#3182ce',
            ],
            'sports' => [
                'label'                 => 'Sports',
                'color'                 => '#e53e3e',
                'backgroundColor'       => '#fed7d7',
                'colorActive'           => '#ffffff',
                'backgroundColorActive' => '#e53e3e',
            ],
            ...
        ];
    }
}
```

### Applying the values to the query

The filter will send you an `array` containing the values that are active.

``` php
final class MyPillFilter extends PillFilter
{
    public function apply(Request $request, $query, $values)
    {
        return $query->whereIn('lifestyle', $values); // $values is an array
    }
}
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Security

If you discover a security vulnerability within this package, please send an email at dllobellmoya@gmail.com instead of using the issue tracker.

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
