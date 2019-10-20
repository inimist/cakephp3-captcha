# CakePHP Captcha Plugin

**Image captcha, Math captcha and Google-recaptcha support for CakePHP**

<a href="https://captcha.inimisttech.com">Demo</a>.

For questions queries please visit this link (coming soon)

## Installation

```composer require inimist/cakephp-captcha:dev-master```

and

```bin/cake plugin load Captcha -b -r```

## Implementation

1. Load **Captcha** plugin.

	If you ran ```bin/cake plugin load Captcha -b -r``` above skip this step.
	
	Place ```Plugin::load('Captcha', ['routes' => true, 'autoload' => true]);``` in your application's **Application.php** or **bootstrap.php** file, whichever applicable.

2. Load **Capthca component**

	Place ```$this->loadComponent('Captcha.Captcha');``` in your controllerr's **initialize** function
	
	OR
	
	Load Captcha component on the fly, in the particular controller **action** function. For example in the signup() action:
	
	```$this->loadComponent('Captcha.Captcha'); //or load on the fly!```$

3. Add Behavior to your Model/Table

	Place  ```$this->addBehavior('Captcha.Captcha', ['field'=>'<fieldname>'])``` in your **Model** (Table class)
	If you use Google Recaptcha add "secret" option with its value which you get from Google Recaptcha. You will add Google site key in the view file below

4. Create an input field in your view's **form** as:

	```echo $this->Captcha->create('<fieldname>', ['options'=>'here', another=>'option']);```
	If you use Google Recaptcha add "sitekey" option with value here. See examples below.

5. In your controller in which your form data is processed, place:

	```$this->Users->setCaptcha('<fieldname>', $this->Captcha->getCode('<fieldname>'));```

	just before patching entity. For example:

	```
	$this->Users->setCaptcha('securitycode', $this->Captcha->getCode('securitycode'));
	$user = $this->Users->patchEntity($user, $this->request->data);
	```
	
See **example/src** folder for a working example.

##More examples

###Custom settings:

    echo $this->Form->create("Signups");
    $custom1['width']=150;
    $custom1['height']=50;
    $custom1['theme']='default';
    echo $this->Captcha->create('captcha_input_field_name', $custom1);
    echo $this->Form->button(__('Submit'));
    echo $this->Form->end();

###Multiple captchas:

    //form 1
    echo $this->Form->create("Signups",['url' => ['controller'=>'signups','action' =>'add']]);
    $custom1['width']=150;
    $custom1['height']=50;
    echo $this->Captcha->create('captcha_input_field_name1', $custom1);
    echo $this->Form->button(__('Submit'));
    echo $this->Form->end();

    //form 2, A math captcha, anywhere on the page
    echo $this->Form->create("Users", ['url' => ['controller'=>'users','action' => 'add']]);
    $custom2['type']='math';
    echo $this->Captcha->create('captcha_input_field_name2', $custom2);
    echo $this->Form->button(__('Submit'));
    echo $this->Form->end();


**Settings that can be set in your view file:**

* *field*: field name.
* *type*: image or math. If set to 'math' all following settings will be 
obsolete
* *width*: width of image captcha
* *height*: height of image captcha
* *theme*: theme/difficulty image captcha
* *length*: number of characters in image captcha
* *angle*: angle of rotation for characters in image captcha

Additional settings that can be set.

* *fontAdjustment*: Responsible for the font size relational to Captcha Image 
Size
* *reload_txt*: The phrase which appears as a Captcha Reload link
* *clabel*: Label for Image Captcha Value input field
* *mlabel*: Label for Math Captcha Value input field

That should be it.

## Known Issues:

1. **Headers already sent** issue. The component uses php's `header()` function to send or generate captcha image as raw HTML output. Make sure there is no output generated before the create() function in your component. It is common error to have spaces, tags or empty space in your files which would cause rending no image in the captcha.

2. **GD library** and True Type Font (**TTF**) support extensions are enabled in PHP.

3. This captcha script uses three font faces, **anonymous**, **droidsans** and **ubuntu**  to generate fonts in the captcha images. These font faces are placed in the **captcha/src/Lib/Fonts** of this download. I have seen that, sometimes, these font files get corrupted during downloads. If you see font not found error in your error logs and captcha are failed to generate, try downloading these font faces from their respective sources and replace them in the mentioned folder. You can also use different font families by placing them Fonts folder and referencing them in the **CaptchaComponent.php** component file.

## Updates

2019-09-23 - Tested with CakePHP 3.8

## Layout

Three basic options, image captcha, math captcha and google-recaptcha

Check older version for more options here.. These should be valid in this version as well.


-----------------------------
Looking for a CakePHP Developer?
-----------------------------
* I like to help with building websites, CRMs, SaaS applications and custom solutions using **CakePHP** & **Wordpress**. [Contact me](https://inimisttech.com/contact/).
* Upwork: https://www.upwork.com/freelancers/~01ea3d34e0a88133b3
