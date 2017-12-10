# CakePHP Captcha Plugin for CakePHP 3.5.*

######Image captcha, Math captcha and Google-recaptcha

A demo can be found here (coming soon)

For any questions queries please visit this link (coming soon)

## Installation

1. Install with composer (coming soon.. skip to next option for now)
2. Download and copy all files to new plugin in your cakephp 3 application as <ROOT>/plugins/captcha folder

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

## Update

No update available

## Layout

Three basic options, image captcha, math captcha and google-recaptcha

Check older version for more options here.. These should be valid in this version as well.
