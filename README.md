# MakeHTML

This is a class and trait for Laravel that will convert text with line breaks and links into HTML. It also adds simple HTML tag generation as well as a helper function for imploding associative arrays.

## Install

Via Composer

``` bash
$ composer require taylornetwork/make-html
```

## Setup

Add the service provider to the providers array in `config/app.php`.

``` php
'providers' => [
    TaylorNetwork\MakeHTML\MakeHTMLServiceProvider::class,
];
```

## Publishing

Run

``` php
php artisan vendor:publish
```

This will add `makehtml.php` to your config directory.

## Usage

You can use this package either by including the trait in a class you want to implement the functionality or by creating a new instance of the class.

### Trait

Import the trait into your class.

``` php
use TaylorNetwork\MakeHTML\MakeHTML;

class DummyClass
{
    use MakeHTML;

    // Code
}
```

The MakeHTML trait includes two functions, usage examples below.

#### makeHTML (string $text)

Accepts one parameter, the text you want the generator to parse.

Given this example variable `$text`

``` php
$text = 'Example text
with line
breaks. And a
link: http://example.com/page/1/2?q=This&that=other';
```

Calling makeHTML

``` php
$this->makeHTML($text);
```

Returns

``` php
'Example text<br>with line<br>breaks. And a<br>link: <a href="http://example.com/page/1/2?q=This&that=other">example.com</a>'
```


#### getHTMLGeneratorInstance ()

Accepts no parameters and returns an instance of HTMLGenerator class, or creates one.

``` php
$this->getHTMLGeneratorInstance();
```

You can chain any methods from the HTMLGenerator class onto that to return functionality.

See class usage below for examples.

### Class

Instantiate the class.

``` php
use TaylorNetwork\MakeHTML\HTMLGenerator;

$instance = new HTMLGenerator();
```

#### Available Methods

##### makeLinks (string $text)

Converts any found links in the string to clickable links with `<a>` tag.

Will take the base URL as the caption for the link.

For example:

``` php
$textWithLink = 'I have a link http://example.com/page/1/2/3?query=string';
```

Call `makeLinks($textWithLink)`

``` php
$instance->makeLinks($textWithLink);
```

Returns

``` php
'I have a link <a href="http://example.com/page/1/2/3?query=string">example.com</a>'
```

##### convertLineEndings (string $text)

Converts all line endings to HTML `<br>` tags.

``` php
$textWithLineBreaks = 'This
is
text
with
line
breaks.';
```

Call `convertLineEndings($textWithLineBreaks)`

``` php
$instance->convertLineEndings($textWithLineBreaks);
```

Returns

``` php
'This<br>is<br>text<br>with<br>line<br>breaks.'
```

##### makeHTML (string $text)

Calls `convertLineEndings($text)` and `makeLinks($text)` and returns the converted text.

##### generateTag (string $tag, array $attributes)

Will generate an HTML tag with any attributes given.

To generate a `<div>` tag with no attributes

``` php
$instance->generateTag('div', []);
```

Returns

``` php
'<div></div>'
```

---

To generate a `<div>` tag with attributes

``` php
$attributes = [ 'class' => 'example-class second-class third' 'data-attr' => 'value' ];
```

Call function

``` php
$instance->generateTag('div', $attributes);
```

Returns

``` php
'<div class="example-class second-class third" data-attr="value"></div>'
```

---

To generate a `<div>` tag with attributes and also data between the tags, add the `external` attribute and everything there will be added between the tags.

``` php
$attributes = [
    'class' => 'example-class',
    'id' => 'div1',
    'name' => 'some-name',
    'external' => 'This is external data!',
];
```

Call function

``` php
$instance->generateTag('div', $attributes);
```

Returns

``` php
'<div class="example-class" id="div1" name="some-name">This is external data!</div>'
```

#### Magic Method

You can also call `generateTag($tag, $attributes)` by calling the tag you want followed by `Tag`

To generate a `<div>` tag this way

``` php
$instance->divTag($attributes);
```

Would call `generateTag('div', $attributes)` for you.

## Helper Function

This package also adds the global helper function `associative_implode` which will implode an associative array into a string.

### Usage

`associative_implode` accepts a minimum of 3 parameters, see table below.

| Parameter # | Description | Type | Suggested Value |
|:-----------:|:-----------:|:----:|:---------------:|
| 1 | The glue between the array key and value | string | `'='` |
| 2 | The glue between each array key/value pair | string | `' '` |
| 3 | The array to implode | array | - |

For all examples the following array will be used.

``` php
$array = [
    'class' => 'class1 class2 class3',
    'id' => 'elementID',
    'data' => 'value',
];
```

#### Default

By default the array values are quoted with `"`

``` php
associative_implode('=', ' ', $array);
```

Returns

``` php
'class="class1 class2 class3" id="elementID" data="value"'
```

#### Additional Parameters

There are an additional 3 parameters that `associative_implode` accepts.

| Parameter # | Description | Type | Default Value |
|:-----------:|:-----------:|:----:|:-------------:|
| 4 | Quote the array keys | boolean | false |
| 5 | Quote the array values | boolean | true |
| 6 | The character used to quote | string | `"` |

To quote array keys and values with `/`

``` php
associative_implode('=', ' ', $array, true, true, '/');
```

Returns

``` php
'/class/=/class1 class2 class3/ /id/=/elementID/ /data/=/value/'
```

## Config

The config file once published is in `config/makehtml.php`

## Credits

- Main Author: [Sam Taylor][link-author]

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

[link-author]: https://github.com/taylornetwork