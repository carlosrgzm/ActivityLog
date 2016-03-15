# ActivityLog
Register all user's information in your Laravel 5 application. (Under development)

[![Latest Stable Version](https://poser.pugx.org/carlosrgzm/activity-log/v/stable)](https://packagist.org/packages/carlosrgzm/activity-log)
[![Total Downloads](https://poser.pugx.org/carlosrgzm/activity-log/downloads)](https://packagist.org/packages/carlosrgzm/activity-log) 
[![Latest Unstable Version](https://poser.pugx.org/carlosrgzm/activity-log/v/unstable)](https://packagist.org/packages/carlosrgzm/activity-log)
[![License](https://poser.pugx.org/carlosrgzm/activity-log/license)](https://packagist.org/packages/carlosrgzm/activity-log)

## Installation

1. Add `carlosrgzm/activity-log` to `composer.json`.

 > "carlosrgzm/activity-log": "dev-master"

2. Run composer update to pull down the latest version.

3. Now open up app/config/app.php and add the service provider to your providers array.

 >  'providers' => array(
        Carlosrgzm\ActivityLog\ActivityLogServiceProvider::class,
    ),

3. Add the alias to the app.php section.
 >  'aliases' => array(
        'ActivityLog' => Carlosrgzm\ActivityLog\Models\ActivityLog::class,,
    ),

## Configuration

Run `php artisan vendor:publish` to generate the migrations and the configuration file in your config folder.

## Usage

For using this package you can add this code in your templates

`ActivityLog::log($data)`

** (As soon as I can, I'll put here an example of $data array)


# TODOS:
- Improve Documentation
- UTs
