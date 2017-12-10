# CakePHP Captcha Plugin for CakePHP 3.5.*

**Image captcha, Math captcha and Google-recaptcha support for CakePHP**

A demo can be found here (coming soon)

For questions queries please visit this link (coming soon)

## Installation

###### Install via Composer
(coming soon.. skip to download option)

###### Install via Download
Download and copy all files to your cakephp 3 application, to new captcha folder in your app's <ROOT>/plugins/ folder

## Configuration

1. Place *Plugin::load('Captcha', ['routes' => true, 'autoload' => true]);* in your application's bootstrap.php file.

2. Place *$this->loadComponent('Captcha.Captcha');* in your controllerr's initialize function

3. Place  *$this->addBehavior('Captcha.Captcha', ['field'=>'<fieldname>'])* in your model (Table class)

4. Create an input field in your form as:
	echo $this->Captcha->create('<fieldname>');

5. Place:

	$this->Users->setCaptcha('<fieldname>', $this->Captcha->getCode('<fieldname>'));

	in your controller, just before patching entity. For example:

	$this->Users->setCaptcha('securitycode', $this->Captcha->getCode('securitycode'));
        $user = $this->Users->patchEntity($user, $this->request->data);

## Updates

No update available

## Layout

Three basic options, image captcha, math captcha and google-recaptcha

Check older version for more options here.. These should be valid in this version as well.
