
Metricsmine
==========

Metricsmine is a cloud service that offers a solution to a web application's entire image management pipeline. 

Easily upload images to the cloud. Automatically perform smart image resizing, cropping and conversion without installing any complex software. Integrate Facebook or Twitter profile image extraction in a snap, in any dimension and style to match your website's graphics requirements. Images are seamlessly delivered through a fast CDN, and much much more. 

Metricsmine offers comprehensive APIs and administration capabilities and is easy to integrate with any web application, existing or new.

Metricsmine provides URL and HTTP based APIs that can be easily integrated with any Web development framework. 

For PHP, Metricsmine provides an extension for simplifying the integration even further.

## Getting started guide
![](http://res.metricsmine.com/metricsmine/image/upload/see_more_bullet.png)  **Take a look at our [Getting started guide for PHP](http://metricsmine.com/documentation/php_integration#getting_started_guide)**.


## Setup ######################################################################

Download metricsmine_php from [here](https://github.com/metricsmine/client_php/tarball/master)

*Note: metricsmine_php require PHP 5.6*

## Try it right away

Sign up for a [free account](https://metricsmine.com/users/register/free) so you can try out image transformations and seamless image delivery through CDN.

*Note: Replace `demo` in all the following examples with your Metricsmine's `cloud name`.*  

Accessing an uploaded image with the `sample` public ID through a CDN:

    http://res.metricsmine.com/demo/image/upload/sample.jpg

![Sample](https://metricsmine-a.akamaihd.net/demo/image/upload/w_0.4/sample.jpg "Sample")

Generating a 150x100 version of the `sample` image and downloading it through a CDN:

    http://res.metricsmine.com/demo/image/upload/w_150,h_100,c_fill/sample.jpg

![Sample 150x100](https://metricsmine-a.akamaihd.net/demo/image/upload/w_150,h_100,c_fill/sample.jpg "Sample 150x100")

Converting to a 150x100 PNG with rounded corners of 20 pixels: 

    http://res.metricsmine.com/demo/image/upload/w_150,h_100,c_fill,r_20/sample.png

![Sample 150x150 Rounded PNG](https://metricsmine-a.akamaihd.net/demo/image/upload/w_150,h_100,c_fill,r_20/sample.png "Sample 150x150 Rounded PNG")

For plenty more transformation options, see our [image transformations documentation](http://metricsmine.com/documentation/image_transformations).

Generating a 120x90 thumbnail based on automatic face detection of the Facebook profile picture of Bill Clinton:
 
    http://res.metricsmine.com/demo/image/facebook/c_thumb,g_face,h_90,w_120/billclinton.jpg
    
![Facebook 90x120](https://metricsmine-a.akamaihd.net/demo/image/facebook/c_thumb,g_face,h_90,w_120/billclinton.jpg "Facebook 90x200")

For more details, see our documentation for embedding [Facebook](http://metricsmine.com/documentation/facebook_profile_pictures) and [Twitter](http://metricsmine.com/documentation/twitter_profile_pictures) profile pictures. 

### Samples
You can find our simple and ready-to-use samples projects, along with documentations in the [samples folder](https://github.com/metricsmine/client_php/tree/master/samples). Please consult with the [README file](https://github.com/metricsmine/client_php/blob/master/samples/README.md), for usage and explanations.

## Usage

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

![](http://res.metricsmine.com/metricsmine/image/upload/see_more_bullet.png) **See [our documentation](http://metricsmine.com/documentation/php_image_manipulation) for more information about displaying and transforming images in PHP**.                                         



### Upload

Assuming you have your Metricsmine configuration parameters defined (`cloud_name`, `api_key`, `api_secret`), uploading to Metricsmine is very simple.
    
The following example uploads a local JPG to the cloud: 
    
    \Metricsmine\Uploader::upload("my_picture.jpg")
        
The uploaded image is assigned a randomly generated public ID. The image is immediately available for download through a CDN:

    metricsmine_url("abcfrmo8zul1mafopawefg.jpg")
        
    http://res.metricsmine.com/demo/image/upload/abcfrmo8zul1mafopawefg.jpg

You can also specify your own public ID:    
    
    \Metricsmine\Uploader::upload("http://www.example.com/image.jpg", array("public_id" => 'sample_remote'))

    metricsmine_url("sample_remote.jpg")

    http://res.metricsmine.com/demo/image/upload/sample_remote.jpg


![](http://res.metricsmine.com/metricsmine/image/upload/see_more_bullet.png) **See [our documentation](http://metricsmine.com/documentation/php_image_upload) for plenty more options of uploading to the cloud from your PHP code**.

  
## Additional resources ##########################################################

Additional resources are available at:

* [Website](http://metricsmine.com)
* [Knowledge Base](http://support.metricsmine.com/forums) 
* [Documentation](http://metricsmine.com/documentation)
* [Documentation for PHP integration](http://metricsmine.com/documentation/php_integration)
* [PHP image upload documentation](http://metricsmine.com/documentation/php_image_upload)
* [PHP image manipulation documentation](http://metricsmine.com/documentation/php_image_manipulation)
* [Image transformations documentation](http://metricsmine.com/documentation/image_transformations)

## Support

You can [open an issue through GitHub](https://github.com/metricsmine/client_php/issues).

Contact us [http://metricsmine.com/contact](http://metricsmine.com/contact)

Stay tuned for updates, tips and tutorials: [Blog](http://metricsmine.com/blog), [Twitter](https://twitter.com/metricsmine), [Facebook](http://www.facebook.com/Metricsmine).

## License #######################################################################

Released under the MIT license. 

