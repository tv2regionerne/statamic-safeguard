# Statamic SafeGuard

> Statamic SafeGuard is an essential add-on for horizontally scaled Statamic CMS,   
> designed to enhance production environment stability by restricting write operations   
> and managing user permissions to prevent unintended changes.

## Features
Add's SafeGuard prevents configured permissions to be assigned for selected environments.  
The super role is also removed for all users, except for those in the whitelist.

> [!IMPORTANT]
> The addon requires users to be stored in Eloquent.

The addon can also be used to prevent end customers to grant them self administrative permissions even with full permissions to e.g. roles.

The addon have the ability to set read only permissions to the files.  
Please notice that this feature is experimental and should only be performed in relation to a deployment og CI build.

## How to Install

Run the following command from your project root:

``` bash
composer require tv2regionerne/statamic-safeguard
```

Publish the config
```bash
php artisan vendor:publish --tag statamic-safeguard-config
```

## How to Use

Update the config `config/statamic-safeguard.php`.  
The safeGuard is already preconfigured for production and staging environment.  
The config already have a preconfigured set of permission to remove in those environments.  
If you need super access, even if you are in a restricted environment, add your e-mail to super array in the config.

> [!CAUTION]
> Experimental!  
> Run the command `php artisan safeguard:disk` to update the filesystem to readonly.
> Please read and update the config. Make sure to backup your files before experimenting with this feature.
