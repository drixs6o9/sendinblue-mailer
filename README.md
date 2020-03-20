Sendinblue Mailer
=================

Provides Sendinblue integration for Symfony Mailer.

[![CI](https://github.com/drixs6o9/sendinblue-mailer/workflows/CI/badge.svg)](https://github.com/drixs6o9/sendinblue-mailer/actions?query=workflow%3ACI)

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
MAILER_DSN=sendinblue://$SENDINBLUE_USERNAME:$SENDINBLUE_PASSWORD@default
###< drixs6o9/sendinblue-mailer ###
```

Your MAILER_DSN can be configured as SMTP with **sendinblue** or **sendinblue+smtp** key, or be configured as STMPS with **sendinblue+smtps** key.

Exemple: 
```env
MAILER_DSN=sendinblue+smtps://$SENDINBLUE_USERNAME:$SENDINBLUE_PASSWORD@default
```

Resources
---------

  * [Report issues](https://github.com/drixs6o9/sendinblue-mailer/issues)
  * [Send Pull Requests](https://github.com/drixs6o9/sendinblue-mailer/pulls)
