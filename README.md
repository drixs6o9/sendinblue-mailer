Sendinblue Mailer
=================

Provides Sendinblue integration for Symfony Mailer.

[![CI](https://github.com/drixs6o9/sendinblue-mailer/workflows/CI/badge.svg)](https://github.com/drixs6o9/sendinblue-mailer/actions?query=workflow%3ACI)
[![Codacy Badge](https://api.codacy.com/project/badge/Grade/878ae9f3a3a74b29b143637c085cd9b2)](https://app.codacy.com/manual/yann.lucas/sendinblue-mailer?utm_source=github.com&utm_medium=referral&utm_content=drixs6o9/sendinblue-mailer&utm_campaign=Badge_Grade_Settings)

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

Finally, add your Sendinblue credentials into your `.env.local` file of your project following the sending method wanted :

**SMTP**:

Your MAILER_DSN can be configured as SMTP with **sendinblue** or **sendinblue+smtp** key, or be configured as STMPS with **sendinblue+smtps** key.

Exemple: 

```env
###> drixs6o9/sendinblue-mailer ###
SENDINBLUE_USERNAME=username
SENDINBLUE_PASSWORD=password
MAILER_DSN=sendinblue+smtps://$SENDINBLUE_USERNAME:$SENDINBLUE_PASSWORD@default
###< drixs6o9/sendinblue-mailer ###
```

**HTTP API**:

You can use HTTP API transport by configuring your DSN as this:

```env
###> drixs6o9/sendinblue-mailer ###
SENDINBLUE_API_KEY=your-api-key
MAILER_DSN=sendinblue+api://$SENDINBLUE_API_KEY@default
###< drixs6o9/sendinblue-mailer ###
```

With HTTP API, you can use custom headers.

```php
$params = ['param1' => 'foo', 'param2' => 'bar'];
$json = json_encode(['"custom_header_1' => 'custom_value_1']);

$email = new Email();
$email
    ->getHeaders()
    ->add(new MetadataHeader('custom', $json))
    ->add(new TagHeader('TagInHeaders1'))
    ->add(new TagHeader('TagInHeaders2'))
    ->addTextHeader('sender.ip', '1.2.3.4')
    ->addTextHeader('templateId', 1)
    ->addParameterizedHeader('params', 'params', $params)
    ->addTextHeader('foo', 'bar')
;
```

This example allow you to set :

*   templateId
*   params
*   tags
*   headers 
    *   sender.ip
    *   X-Mailin-Custom

For more informations, you can refer to [Sendinblue API documentation](https://developers.sendinblue.com/reference#sendtransacemail).

Resources
---------

*   [Report issues](https://github.com/drixs6o9/sendinblue-mailer/issues)
*   [Send Pull Requests](https://github.com/drixs6o9/sendinblue-mailer/pulls)

Contributors
------------
*   [drixs6o9](https://github.com/drixs6o9)
*   [ptondereau](https://github.com/ptondereau)
