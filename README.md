
metricsmine
==========

metricsmine is a Real-time Cloud Application and Business Monitoring

metricsmine provides a complete and scalable solution for real-time application monitoring the metrics that impact your business. We provide you with everything you need to know, actively alert you of the most important metrics and logs, and help you to visualize and analyse the data that matters to you.

Metricsmine offers comprehensive APIs and administration capabilities and is easy to integrate with any web application, existing or new.

Metricsmine provides URL and HTTP based APIs that can be easily integrated with any Web development framework.

For PHP, Metricsmine provides an extension for simplifying the integration even further.

## Getting started guide
**Take a look at our [Getting started guide for PHP](https://metricsmine.com/docs/php)**.


## Setup ######################################################################

Download metricsmine/client-php from [here](https://github.com/metricsmine/client-php/tarball/master)

*Note: metricsmine/client-php require PHP 5.6*


### Configuration

    $client = metricsmine\clientPHP\Client::forge()
        ->keys($public, $private)
        ->service('php')
        ->instance(gethostname());

    $client
        ->trace(true)
        ->message($variable)
        ->event();

    $client
        ->trace(true)
        ->message(['message' => $message])
        ->event();

    $client
        ->metric('cpu');

**See [our documentation](http://metricsmine.com/documentation/php_image_manipulation) for more information about displaying and transforming images in PHP**.

## Additional resources ##########################################################

Additional resources are available at:

* [Website](https://metricsmine.com/)

## Support

You can [open an issue through GitHub](https://github.com/metricsmine/client-php/issues).

Contact us [http://metricsmine.com/contact](http://metricsmine.com/contact)

## License #######################################################################

Released under the MIT license.
