CHANGELOG
=========

### master (2015-10-02)

* [BC BREAK] The Doctrine manager registry is now injected in the ``ContactManager`` to fix Symfony 3.0 compatibility.

### master (2015-09-25)

* The fields are now optionals for doctrine. So you can remove some fields if you don't want them and store in database.

### master (2015-09-15)

* [BC BREAK] Removed ``mremi/bootstrap-bundle`` dependency.

### master (2015-01-28)

* Allow multiple To for Swift mailer
* [BC BREAK] Removed ``mremi_contact.email.recipient_adress`` config, replaced by ``mremi_contact.email.to``.

### master (2015-01-05)

* Allow any captcha form field type.
* [BC BREAK] Removed Genemu dependency.
* [BC BREAK] Removed ``mremi_contact.form.captcha_disabled`` configuration option.
