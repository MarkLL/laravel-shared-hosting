# Laravel Setup for Shared Hosting
This repository contains the required files to enable you to easily and safely install you Laravel Application on a Shared cPanel web server.

## Introduction
One of **Laravel's** strengths, in my opinion, is that all the source code is located outside the Public folder. This means that the files can't be accessed directly. This is a complete contrast to something like WordPress where all the files are located in the public folder.

The one big mistake that many newbie Laravel developers make when installing their Laravel app is that they place all the code inside the public folder. And then attempt to make it work via complicated redirects etc. Well there is an easier way.

## The Problem
Here is the typical layout of a Laravel app installed into a "webApp" folder where the **public** folder is specified as the public root. For subdomains this is actually very easy to do because you can specify the correct public root when you add the subdomain.

```
/home/username/webApp|
                     |--app
                     |--bootstrap
                     |--...
                     |--public
```

However, the main domain has the public root set to **public_html** which can't be changed (normally).
```
/home/username|
              |--access-logs
              |--etc
              |--logs
              |--mail
              |--public_html
```


## The Solution
Instead of fighting the config, work with it... Here's what I do.
1. Create you **webApp** folder as you normally would under the username folder and install you app.
2. Copy the content of the public folder to the public_html folder.
3. Install the files included in this repository overtop of the existing files and off you go.

```
/home/username|
              |--access-logs
              |--etc
              |--logs
              |--mail
              |--public_html
              |--webApp
```

## Setting up the development environment
I'm certainly not going to try and tell you how you should structure your development environment, however I'll illustrate how I organise it and highlight the advantages.

1. So we have a Development Root folder on a drive not associated with the operating system.<br>
**e.g. `D:\dev`**
* Best to separate data from the OS if possible. Better performance and easier backup / replacement of drives if one fails.
* I like the name to be as short as possible as long as it has meaning. `Dev` is one letter shorter than `Code`.

2. Under here we have a folder for each project, but instead of creating you new project directly under dev, first create a project directory (`D:\dev\MarkLL`) and install you new Laravel application into the `webApp` folder. **e.g. `D:\dev\MarkLL\webApp`**<br>
with **composer** you would run:<br>
`composer create-project --prefer-dist laravel/laravel webApp`<br>
with the **Laravel Installer**, it would be:<br>
`laravel new webApp`

3. Once installed, **COPY** the content of the **public** folder to a new **public_html** folder also under you project folder.<br>
**e.g. `D:\dev\MarkLL\public_html`**
<br><br>
Extract the content of this repository into your Project folder and allow it to overwrite the existing files..

You are now ready to begin your development.

## Summary of changes
1. Additional Application subclass (`app/Application.php`). This file adds the ability to accept a Public Path as a parameter at startup. It also overrides the default `publicPath()` method.
2. Replacement `server.php` file with the new Public Path configured.
3. Replacement `boostrap/app.php` file that initialises our Application subclass and passes our desired Public Path as a second paremeter.
4. Replacement `webpack.mix.js` file. Basically this copies the compiled asstets to the correct public path. **Note** it's easier to just copy the assets rather than try and get it to work with the new public path due to bugs in the javascript compilers.
5. Replacement `index.php` file for the public_html folder. The path to locate the required files has been updated.

## Tips for Windows Users
1. Install Windows Subsystem for Linux (WSL) to prepare the source for upload.
2. In Bash, create a username that matches the account name used in your cPanel hosting account.
3. Copy you app to a **webApp** folder, then move the contents of the Public folder to **public_html** (or copy your dev public_html contents).
4. Install the files from this repository and then run `composer install` and `php artisan optimize config`.
5. Zip up the content of the webApp and public_html folders and upload that to your webserver. Then use cPanels' *File Manager* to extract the zip into your home directory.

**Note:** You are strongly advised to set this up in your development enviornment as well.

## FAQs
1. Does the `php artisan serve` work?<br>
Yes it does. The modified server.php file now points to the public_html folder and works as expected.
2. Does `php artisan storage:link` work?<br>
Yes, thankfully the command calls $app->publicPath() so the correct public path is used.
3. Do I have to call the app folder `webApp`?<br>
No, you can change it to something else... **However** you will need to change the files to reflect the name change.
4. What version of Laravel does this work with?<br>
I have personally used these modification since v5.1 and it still works with the latest version (v5.7)
5. Does this work with Lumen?<br>
Yes and no. The same method of overriding works but you will need to modify the Lumen files as this repository is for Laravel only.
