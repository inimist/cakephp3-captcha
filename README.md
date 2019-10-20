# CakePHP Captcha Plugin

**Bot Detect using Image captcha, Math captcha and Google-recaptcha for CakePHP 3**

## Quick Features

No Custom Code required
Quick install. Just add three lines of code in your Controller, Model and View 1 line each.
Works in Model Validation
Easy to switch between Google Recaptcha, Image Captcha and Math Challenge
Multiple Captchas on single page
Multiple Demo available.
Demo available as CakePHP Plugin

## Installation

```composer require inimist/cakephp-captcha```

and

```bin/cake plugin load Captcha -b -r```

## Implementation

1. Load **Captcha** plugin.

	If you ran ```bin/cake plugin load Captcha -b -r``` above skip this step.
	
	Place ```Plugin::load('Captcha');``` in your application's **Application.php** or **bootstrap.php** file.

2. Load **Capthca component**

	Place ```$this->loadComponent('Captcha.Captcha');``` in your controllerr's **initialize** function
	
	OR
	
	Load Captcha component on the fly, in the particular controller **action** function. For example in the signup() action:
	
	```$this->loadComponent('Captcha.Captcha'); //or load on the fly!```$

3. Add Behavior to your Model/Table

	Place  ```$this->addBehavior('Captcha.Captcha', ['field'=>'<fieldname>'])``` in your **Model** (Table class)
	Note: If you use Google Recaptcha add "secret" option with its value which you get from Google. Also, add Google site key in the view file.

4. Create an input field in your view's **form** as:

	```echo $this->Captcha->create('<fieldname>', $options);```
	If you use Google Recaptcha add "sitekey" option with its value here. See examples below.

5. In your controller in which your form data is processed, place:

	```$this->Users->setCaptcha('<fieldname>', $this->Captcha->getCode('<fieldname>'));```

	just before patching entity. For example:

	```
	$this->Users->setCaptcha('securitycode', $this->Captcha->getCode('securitycode'));
	$user = $this->Users->patchEntity($user, $this->request->data);
	```

A fully working demo can be found [here](https://captcha.inimisttech.com). You can install a fully working demo as a plugin from [here](https://github.com/inimist/cakephp-captcha-demo).

##More examples

###$options:

    $options['width']=150;
    $options['height']=50;
    $options['theme']='default';
    echo $this->Captcha->create('captcha_input_field_name', $options);

###Multiple Captchas on same page:

    //form 1
    $options1['width']=150;
    $options1['height']=50;
    echo $this->Captcha->create('captcha_input_field_name1', $options1);

    //form 2, A math captcha, anywhere on the page
    $options2['type']='math';
    echo $this->Captcha->create('captcha_input_field_name2', $custom2);

**Options for view template. Ex: `$this->Captcha->create('field_name', $options)`:**

* *field*: field name (Optional. Default "captcha")
* *type*: recaptcha/image/math (Optional: Default "image")
* *width*: width of image captcha (Optional. Applies to type "image" only)
* *height*: height of image captcha (Optional. Applies to type "image" only)
* *theme*: default/random image captcha color pattern (Optional. Applies to type "image" only ; default "default")
* *length*: number of characters in image captcha (Optional. Applies to type "image" only)
* *angle*: angle of rotation for characters in image captcha (Optional. Applies to type "image" only)
* *fontAdjustment*: Font size for Image Captcha (Optional. Applies to type "image" only)
* *reload_txt*: Reload Captcha Text (Optional)
* *clabel*: Label for Image Captcha field (Optional)
* *mlabel*: Label for Math Captcha field (Optional)
* *sitekey*: Googel Recaptcha Sitekey (Required. Applies to type "recatpcha" only)

(All above options can also be set from controller. Ex: `$this->loadComponent('Captcha.Captcha', $options)`)

**Options for model. Ex: $this->addBehavior('Captcha.Captcha', $options);

* *field*: field name (optional: default "captcha")
* *secret*: Googel Recaptcha Secret (required for type "recatpcha")

## Known Issues:

1. **Headers already sent** issue. The component uses php's `header()` function to send or generate captcha image as raw HTML output. Make sure there is no output generated before the create() function in your component. It is common error to have spaces, tags or empty space in your files which would cause rending no image in the captcha.

2. **GD library** and True Type Font (**TTF**) support extensions are enabled in PHP.

3. This captcha script uses three font faces, **anonymous**, **droidsans** and **ubuntu**  to generate fonts in the captcha images. These font faces are placed in the **captcha/src/Lib/Fonts** of this download. I have seen that, sometimes, these font files get corrupted during downloads. If you see font not found error in your error logs and captcha are failed to generate, try downloading these font faces from their respective sources and replace them in the mentioned folder. You can also use different font families by placing them Fonts folder and referencing them in the **CaptchaComponent.php** component file.

## Updates

2019-09-23 - Tested with CakePHP 3.8