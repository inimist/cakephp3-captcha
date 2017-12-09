Cakephp Captcha AND Google Recaptcha Support 3.3
=============================

CakePHP Captcha support. Tested with CakePHP 3.3.10

[CakePHP 2.x version is here](https://github.com/inimist/cakephp-captcha)

Features
--------------------
* Multiple Captcha Support.
	- It simply supports multiple captchas on a page. In different forms or in a single form.
* Includes Google Recaptcha Support
* Model Validation attahced as Behavior
* Image and Simple Math Captcha
* Configurable Model Name, Field Name, Captcha Height, Width, Number of Characters and Font Face, Size, Angle of rotation
* Works without GD Truetype font support
* Random or Fixed Captcha Themes for Image Captchaa
* Random Font face

Demo
--------------------
http://captcha.inimist.com


Installation
--------------------

Place all files (except "controller" and "table" file) bundled in this package in corresponding folders.

Follow instructions given below to place code in Controller, Model\Table and Template files.

###In Controller

Add in the top initialize function of your Controller.

    $this->loadComponent('Captcha', ['field'=>'securitycode']);

Note: In these examples "*captcha*" and *User* are the default input field name and the Table names respectively. Replace with appropriate names.

Add this function in your controller.

    function captcha()	{
        $this->autoRender = false;
        $this->viewBuilder()->layout('ajax');
        $this->Captcha->create();
    }

Add similar logic to the the "action" of your form in your controller. Line ending with comment "//captcha" is the one which is related to the captcha call.

    public function add()
    {
        $user = $this->Users->newEntity();
        if ($this->request->is('post')) {
	    $this->Users->setCaptcha('securitycode', $this->Captcha->getCode('securitycode')); //captcha
            $user = $this->Users->patchEntity($user, $this->request->data);
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The user could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('user'));
        $this->set('_serialize', ['user']);
    }


###In Model\Table\UsersTable.php

Add following code in the initialize function:

	$this->addBehavior('Captcha', [
	'field' => 'securitycode',
	'message' => 'Incorrect captcha code value'
	]);

###In Template\User\add.ctp

In the view file, add the following line of code, wherever you want captcha image and input box to be appeared:

    echo $this->Captcha->create('securitycode', $settings); //$settings are optional

Also place the following javascript script code in somewhere in your page body so it is called properly and executed. Skip jquery library call if already loaded.

    <script 
    src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></scr
    ipt>
    <script>
    jQuery('.creload').on('click', function() {
        var mySrc = $(this).prev().attr('src');
        var glue = '?';
        if(mySrc.indexOf('?')!=-1)  {
            glue = '&';
        }
        $(this).prev().attr('src', mySrc + glue + new Date().getTime());
        return false;
    });
    </script>
    
Google Recaptcha
--------------------

Add **type** = **recaptcha** and **sitekey** in the view file (see included **add.ctp**)
Add secret in the behavior configuration, in Table file (See **UserTable.php**) OR **CaptchaBehavior.php**

That should be it!

Optional Configuration
--------------------
Open the Controller/Component/CaptchaComponent.php file and make necessary changes in the $settings variable defined near line 130.

##More examples

###Custom settings:

    echo $this->Form->create($user);
    $custom1['width']=150;
    $custom1['height']=50;
    $custom1['theme']='default';
    echo $this->Captcha->create($custom1);

###Multiple captchas:

    //form 1
    echo $this->Form->create($user);
    $custom1['width']=150;
    $custom1['height']=50;
    echo $this->Captcha->create($custom1);

    //form 2, A math captcha, anywhere on the page
    echo $this->Form->create($user);
    $custom2['type']='math';
    echo $this->Captcha->create($custom2);


**Settings that can be set in your view file:**

* *model*: model name.
* *field*: field name.
* *type*: image or math. If set to 'math' all following settings will be 
obsolete
* *width*: width of image captcha
* *height*: height of image captcha
* *theme*: theme/difficulty image captcha
* *length*: number of characters in image captcha
* *angle*: angle of rotation for characters in image captcha

Additional settings that can be set in Component file.

* *fontAdjustment*: Responsible for the font size relational to Captcha Image 
Size
* *reload_txt*: The phrase which appears as a Captcha Reload link
* *clabel*: Label for Image Captcha Value input field
* *mlabel*: Label for Math Captcha Value input field

Notes
--------------------
* Math captha is working now.
* Tested with CakePHP 3.1.1

License
--------------------
* Licensed under The MIT License
* Redistributions of files must retain the given copyright notice.
* http://opensource.org/licenses/MIT

##Issues & Support

####Captcha Image not Displaying

There is a known issue with the Fonts file. When I push fonts through git I think they get corrupted. So it give error like this

SWarning (2): imagettfbbox(): Could not read font [APP/Controller\Component\CaptchaComponent.php, line 372]Error in imagettfbbox function

Solution
Please download font files from:

https://github.com/google/fonts. Just search there for each font and download it to your desktop. 

AnonymousPro-Regular.ttf
DroidSans.ttf
Ubuntu-Regular.ttf

Now rename them to anonymous.ttf, droidsans.ttf and ubuntu.ttf respectively and replace fonts in Lib/fonts folder in you cakephp/src folder.


Copyright
--------------------
Copyright (C) Arvind Kumar, arvind@inimist.com, All rights reserved.
