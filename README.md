MremiContactBundle
==================

This bundle provides a contact form in Symfony2.

**Note:**

> This bundle is not yet complete but is functional. I'm still working on it.
> However you can contribute if you want.
> I'm also interested by your feedback ;-) .

## Prerequisites

This version of the bundle requires Symfony 2.1+.

### Translations

If you wish to use default texts provided in this bundle, you have to make
sure you have translator enabled in your config.

``` yaml
# app/config/config.yml

framework:
    translator: ~
```

For more information about translations, check [Symfony documentation](http://symfony.com/doc/current/book/translation.html).

### Extra form

This bundle requires the [GenemuFormBundle](https://github.com/genemu/GenemuFormBundle) for an easy captcha integration,
so you need to configure it.

## Installation

Installation is a quick 4 step process:

1. Download MremiContactBundle using composer
2. Enable the Bundle
3. Configure the MremiContactBundle
4. Import MremiContactBundle routing

### Step 1: Download MremiContactBundle using composer

Add MremiContactBundle in your composer.json:

```js
{
    "require": {
        "mremi/contact-bundle": "dev-master"
    }
}
```

Now tell composer to download the bundle by running the command:

``` bash
$ php composer.phar update mremi/contact-bundle
```

Composer will install the bundle to your project's `vendor/mremi` directory.

### Step 2: Enable the bundle

Enable the bundle in the kernel:

``` php
<?php
// app/AppKernel.php

public function registerBundles()
{
    $bundles = array(
        // ...
        new Mremi\ContactBundle\MremiContactBundle(),
    );
}
```

### Step 3: Configure the MremiContactBundle

The bundle comes with a sensible default configuration, which is listed below.
However you have to configure at least the recipient address.

```yaml
# app/config/config.yml
mremi_contact:
    email:
        mailer:            mremi_contact.mailer.twig_swift
        recipient_address: webmaster@example.com
        template:          MremiContactBundle:Contact:email.txt.twig

    contact_class:         Mremi\ContactBundle\Model\Contact

    form:
        type:              mremi_contact
        name:              contact_form
        validation_groups: [Default]
        captcha_disabled:  false
        captcha_type:      genemu_captcha
```

### Step 4: Import MremiContactBundle routing

Now that you have activated and configured the bundle, all that is left to do is
import the MremiContactBundle routing file.

By importing the routing file you will have ready access the contact form.

In YAML:

``` yaml
# app/config/routing.yml
mremi_contact_form:
    resource: "@MremiContactBundle/Resources/config/routing.xml"
```

Or if you prefer XML:

``` xml
<!-- app/config/routing.xml -->
<import resource="@MremiContactBundle/Resources/config/routing.xml"/>
```

**Note:**

> In order to use the built-in email functionality, you must activate and
> configure the SwiftmailerBundle.

You can now access to the contact form at `http://example.com/app_dev.php/contact`!

**Note:**

> The HTML5 validation can be disabled by adding `?novalidate=1` to the URL.
