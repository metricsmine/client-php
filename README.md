
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

Each request for building a URL of a remote cloud resource must have the `cloud_name` parameter set. 
Each request to our secure APIs (e.g., image uploads, eager sprite generation) must have the `api_key` and `api_secret` parameters set. See [API, URLs and access identifiers](http://metricsmine.com/documentation/api_and_access_identifiers) for more details.

Setting the `cloud_name`, `api_key` and `api_secret` parameters can be done either directly in each call to a Metricsmine method, by calling the Metricsmine::config(), or by using the CLOUDINARY_URL environment variable.

### Embedding and transforming images

Any image uploaded to Metricsmine can be transformed and embedded using powerful view helper methods:

The following example generates the url for accessing an uploaded `sample` image while transforming it to fill a 100x150 rectangle:

    metricsmine_url("sample.jpg", array("width" => 100, "height" => 150, "crop" => "fill"))

Another example, emedding a smaller version of an uploaded image while generating a 90x90 face detection based thumbnail: 

    metricsmine_url("woman.jpg", array("width" => 90, "height" => 90, "crop" => "thumb", "gravity" => "face"))

You can provide either a Facebook name or a numeric ID of a Facebook profile or a fan page.  
             
Embedding a Facebook profile to match your graphic design is very simple:

    metricsmine_url("billclinton.jpg", array("width" => 90, "height" => 130, "type" => "facebook", "crop" => "fill", "gravity" => "north_west"))
                           
Same goes for Twitter:

    metricsmine_url("billclinton.jpg", array("type" => "twitter_name"))

**See [our documentation](http://metricsmine.com/documentation/php_image_manipulation) for more information about displaying and transforming images in PHP**.                                         

  
## Additional resources ##########################################################

Additional resources are available at:

* [Website](https://metricsmine.com/)
* [Knowledge Base](http://support.metricsmine.com/forums) 
* [Documentation](http://metricsmine.com/documentation)
* [Documentation for PHP integration](http://metricsmine.com/documentation/php_integration)

## Support

You can [open an issue through GitHub](https://github.com/metricsmine/client-php/issues).

Contact us [http://metricsmine.com/contact](http://metricsmine.com/contact)

Stay tuned for updates, tips and tutorials: [Blog](http://metricsmine.com/blog), [Twitter](https://twitter.com/metricsmine), [Facebook](http://www.facebook.com/Metricsmine).

## License #######################################################################

Released under the MIT license. 

