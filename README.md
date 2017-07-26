[![Build Status](https://travis-ci.org/metricsmine/client_php.svg)](https://travis-ci.org/metricsmine/client_php) [![license](https://img.shields.io/github/license/metricsmine/client_php.svg?maxAge=2592000)]() [![Packagist](https://img.shields.io/packagist/v/metricsmine/client_php.svg?maxAge=2592000)]() [![Packagist](https://img.shields.io/packagist/dt/metricsmine/client_php.svg?maxAge=2592000)]()

Metricsmine
==========

Metricsmine is a cloud service that offers a solution to a web application's entire image management pipeline. 

Easily upload images to the cloud. Automatically perform smart image resizing, cropping and conversion without installing any complex software. Integrate Facebook or Twitter profile image extraction in a snap, in any dimension and style to match your website's graphics requirements. Images are seamlessly delivered through a fast CDN, and much much more. 

Metricsmine offers comprehensive APIs and administration capabilities and is easy to integrate with any web application, existing or new.

Metricsmine provides URL and HTTP based APIs that can be easily integrated with any Web development framework. 

For PHP, Metricsmine provides an extension for simplifying the integration even further.

## Getting started guide
![](http://res.metricsmine.com/metricsmine/image/upload/see_more_bullet.png)  **Take a look at our [Getting started guide for PHP](http://metricsmine.com/documentation/php_integration#getting_started_guide)**.


## CakePHP ##
Dedicated CakePHP plugin is also available. You can browse the code, installation and usage information [at the `metricsmine_cake_php` repository](https://github.com/metricsmine/metricsmine_cake_php).

## Setup ######################################################################

Download metricsmine_php from [here](https://github.com/metricsmine/client_php/tarball/master)

*Note: metricsmine_php require PHP 5.3*

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


### cl\_image\_tag

Returns an html image tag pointing to Metricsmine.

Usage:

    <?php echo cl_image_tag("sample", array("format"=>"png", "width"=>100, "height"=>100, "crop"=>"fill") ?>

    # <img src='http://res.metricsmine.com/cloud_name/image/upload/c_fill,h_100,w_100/sample.png' height='100' width='100'/>



### cl\_image\_upload\_tag

Returns an html input field for direct image upload, to be used in conjunction with [metricsmine\_js package](https://github.com/metricsmine/metricsmine_js/). It integrates [jQuery-File-Upload widget](https://github.com/blueimp/jQuery-File-Upload) and provides all the necessary parameters for a direct upload.
You may see a sample usage of this feature in the PhotoAlbum sample included in this project.

Usage:

    cl_image_upload_tag(post-upload-field-name, upload-options-array)

Parameters:

 - `post-upload-field-name` - A name of a field in the form to be updated with the uploaded file data.
      If no such field exists a new hidden field will be creates.   
      The value format is `<image-path>#<public-id>`.   
      If the `cl_image_upload_tag` is not within an html form, this argument is ignored.

 - `upload-options-array` - upload options same as in Upload section above, with:
      - html - an associative array of html attributes for the upload field

![](http://res.metricsmine.com/metricsmine/image/upload/see_more_bullet.png) **See [our documentation](http://metricsmine.com/documentation/php_image_upload#direct_uploading_from_the_browser) for plenty more options of uploading directly from the browser**.


### cl\_form\_tag

The following function returns an html form that can be used to upload the file directly to Metricsmine. The result is a redirect to the supplied callback_url.

    cl_form_tag(callback, array(...))

Optional parameters:

    public_id - The name of the uploaded file in Metricsmine
    form - html attributes to be added to the form tag
    Any other parameter that can be passed to \Metricsmine\Uploader::upload

## Development

### Testing

To run the PHPUnit test suite you must first set the environment variable containing your Metricsmine URL. This can be obtained via Metricsmine's Management Console.

    export CLOUDINARY_URL=metricsmine://123456789012345:abcdeghijklmnopqrstuvwxyz12@n07t21i7

Next you can run your the PHPUnit suite from the root of this library:

   phpunit tests/* 
  
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

