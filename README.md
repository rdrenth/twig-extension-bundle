RdrenthTwigExtensionBundle
=============

## About
This is a Symfony2 Bundle that provides you with some extensions to Twig!

## Twig extensions

### Stringy
This extension provides the following filters (provided by the [Stringy](https://github.com/danielstjules/Stringy) package).

For more information about each filter, please check the links.

#### [ascii](https://github.com/danielstjules/Stringy#toascii)

```twig
{{ 'fòôbàř'|ascii }} {# foobar #}
```

#### [camelize](https://github.com/danielstjules/Stringy#camelize)

```twig
{{ 'Camel-Case'|camelize }} {# camelCase #}
```

#### [dasherize](https://github.com/danielstjules/Stringy#dasherize)

```twig
{{ 'fooBar'|dasherize }} {# foo-bar #}
```

#### [delimit](https://github.com/danielstjules/Stringy#delimit)

```twig
{{ 'fooBar'|delimit('::') }} {# foo::bar #}
```

#### [humanize](https://github.com/danielstjules/Stringy#humanize)

```twig
{{ 'author_id'|humanize }} {# Author #}
```

#### [slugify](https://github.com/danielstjules/Stringy#slugify-string-replacement----)

```twig
{{ 'Using strings like fòô bàř'| slugify }} {# using-strings-like-foo-bar #}
```

#### [titleize](https://github.com/danielstjules/Stringy#titleize-array-ignore)

```twig
{{ 'i like to watch television'|titleize(['to']) }} {# I Like to Watch Television #}
```

#### [underscored](https://github.com/danielstjules/Stringy#underscored)

```twig
{{ 'TestUCase'|underscored }} {# test_u_case #}
```


## Installation
### Step 1: Install RdrenthTwigExtensionBundle using [Composer](http://getcomposer.org)

```bash
$ composer require rdrenth/twig-extension-bundle
```
### Step 2: Enable the bundle
```php
<?php

// app/AppKernel.php
public function registerBundles()
{
    $bundles = array(
        // ...
        new Rdrenth\Bundle\TwigExtensionBundle\RdrenthTwigExtensionBundle(),
        // ...
    );
}
```

### Step 3: Configure your `config.yml` file
By default the filters are disabled, enable the filters you want to use like this:

```yaml
# app/config/config.yml
          
rdrenth_twig_extension:
    stringy:
        filters:
            ascii: ~
            camelize: ~
```

It is also possible to modify the filter name that is being used in Twig:

```yaml
# app/config/config.yml
          
rdrenth_twig_extension:
    stringy:
        filters:
            camelize:
                filter: camels
```

Or provide extra filters which are not available by default from the Stringy package (the method has to exist in the [Stringy class](https://github.com/danielstjules/Stringy/blob/master/src/Stringy.php)):

```yaml
# app/config/config.yml
          
rdrenth_twig_extension:
    stringy:
        extra_filters:
            - { filter: swap_case, method: swapCase }
```

## License

This bundle is under the MIT license. See the complete license in the bundle:

    Resources/meta/LICENSE
    
