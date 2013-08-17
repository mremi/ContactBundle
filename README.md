MremiContactBundle
==================

[![SensioLabsInsight](https://insight.sensiolabs.com/projects/7c3f02d7-cfc4-4e6a-9892-28ba24a8ecd2/big.png)](https://insight.sensiolabs.com/projects/7c3f02d7-cfc4-4e6a-9892-28ba24a8ecd2)

[![Build Status](https://api.travis-ci.org/mremi/ContactBundle.png?branch=master)](https://travis-ci.org/mremi/ContactBundle)
[![Total Downloads](https://poser.pugx.org/mremi/contact-bundle/downloads.png)](https://packagist.org/packages/mremi/contact-bundle)
[![Latest Stable Version](https://poser.pugx.org/mremi/contact-bundle/v/stable.png)](https://packagist.org/packages/mremi/contact-bundle)

This bundle provides a contact form in Symfony2.

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

Installation is a quick 6 step process:

1. Download MremiContactBundle using composer
2. Enable the Bundle
3. Create your Contact class (optional)
4. Configure the MremiContactBundle
5. Import MremiContactBundle routing
6. Update your database schema (optional)

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

### Step 3: Create your Contact class (optional)

The goal of this bundle is not to persist some `Contact` class to a database,
but you can if you want just by setting the `store_data` parameter to `true`
(default `false`).
So if you don't need to do this, you can jump to the next step.

Your first job, then, is to create the `Contact` class for your application.
This class can look and act however you want: add any properties or methods you
find useful. This is *your* `Contact` class.

The bundle provides base classes which are already mapped for most fields
to make it easier to create your entity. Here is how you use it:

1. Extend the base `Contact` class from the ``Entity`` folder
2. Map the `id` field. It must be protected as it is inherited from the parent class.

**Note:**

> For now, only Doctrine ORM is handled by this bundle (any PR will be
> appreciated :) ).

``` php
<?php
// src/Acme/ContactBundle/Entity/Contact.php

namespace Acme\ContactBundle\Entity;

use Mremi\ContactBundle\Entity\Contact as BaseContact;

class Contact extends BaseContact
{
    /**
     * @var integer
     */
    protected $id;
}
```

``` xml
<!-- src/Acme/ContactBundle/Resources/config/doctrine/Contact.orm.xml -->
<?xml version="1.0" encoding="UTF-8"?>
<doctrine-mapping xmlns="http://doctrine-project.org/schemas/orm/doctrine-mapping"
                  xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
                  xsi:schemaLocation="http://doctrine-project.org/schemas/orm/doctrine-mapping
                  http://doctrine-project.org/schemas/orm/doctrine-mapping.xsd">

    <entity name="Acme\ContactBundle\Entity\Contact"
            table="contact">

        <id name="id" column="id" type="integer">
            <generator strategy="AUTO" />
        </id>

    </entity>
</doctrine-mapping>
```

### Step 4: Configure the MremiContactBundle

The bundle comes with a sensible default configuration, which is listed below.
However you have to configure at least the recipient address.

```yaml
# app/config/config.yml
mremi_contact:
    store_data:            false
    contact_class:         Mremi\ContactBundle\Model\Contact

    form:
        type:              mremi_contact
        name:              contact_form
        validation_groups: [Default]
        captcha_disabled:  false
        captcha_type:      genemu_captcha

    email:
        mailer:            mremi_contact.mailer.twig_swift
        recipient_address: webmaster@example.com
        template:          MremiContactBundle:Contact:email.txt.twig
```

### Step 5: Import MremiContactBundle routing

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

### Step 6: Update your database schema (optional)

If you configured the data storage (step 3), you can now update your database
schema.

If you want to first see the create table query:

``` bash
$ app/console doctrine:schema:update --dump-sql
```

Then you can run it:

``` bash
$ app/console doctrine:schema:update --force
```

You can now access to the contact form at `http://example.com/app_dev.php/contact`!

**Note:**

> If your are in debug mode (see your front controller), the HTML5 validation
> can be disabled by adding `?novalidate=1` to the URL.

## Bootstrap

[Bootstrap framework](http://getbootstrap.com/) is loaded and used in templates
provided by this bundle.

![Screenshot](https://raw.github.com/mremi/ContactBundle/master/Resources/doc/images/form.png)

## Customization

### Templating

If you want to customize some parts of this bundle (views for instance), read
the [Symfony documentation](http://symfony.com/doc/current/cookbook/bundles/inheritance.html).

### Events

The contact controller dispatches 3 events during the index action:

1. ContactEvents::FORM_INITIALIZE occurs when the form is initialized
2. ContactEvents::FORM_SUCCESS occurs when the form is submitted successfully
3. ContactEvents::FORM_COMPLETED occurs after saving the contact in the contact form process

Each one allows you to customize the default workflow provided by this bundle.
