Sendinblue Mailer
=================

Provides Sendinblue integration for Symfony Mailer.

[![CircleCI](https://circleci.com/gh/drixs6o9/sendinblue-mailer/tree/master.svg?style=svg)](https://circleci.com/gh/drixs6o9/sendinblue-mailer/tree/master)

Installation
------------

Open a command console inyour project directory and execute the
following command to download the latest stable version of this bundle:

```bash
$ composer require drixs6o9/sendinblue-mailer
```

Then, enable the bundle by adding the following line in the `config/bundle.php`
file of your project:

```php
<?php
// config/bundle.php

return [
    // ...
    Drixs6o9\SendinblueMailerBundle\SendinblueMailerBundle::class => ['all' => true],
];
```

Finally, add your Sendinblue credentials into your `.env.local` file of your project:
```env
###> drixs6o9/sendinblue-mailer ###
SENDINBLUE_USERNAME=username
SENDINBLUE_PASSWORD=password
MAILER_DSN=smtp://$SENDINBLUE_USERNAME:$SENDINBLUE_PASSWORD@sendinblue
###< drixs6o9/sendinblue-mailer ###
```

Resources
---------

  * [Report issues](https://github.com/drixs6o9/sendinblue-mailer/issues)
  * [Send Pull Requests](https://github.com/drixs6o9/sendinblue-mailer/pulls)
