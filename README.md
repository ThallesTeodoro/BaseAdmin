# BaseAdmin
[![Latest Version on Packagist](https://img.shields.io/github/issues/ThallesTeodoro/BaseAdmin.svg?style=flat-square)](https://packagist.org/packages/thalles/baseadmin)
[![Total Downloads](https://img.shields.io/github/stars/ThallesTeodoro/BaseAdmin.svg?style=flat-square)](https://packagist.org/packages/thalles/baseadmin)
## A tool to setup a admin site with auth and user crud, using adminlte!

### **Requirements**
- PHP >= 7.2.5
- laravel/framework ^7.0

---

### **1. Installation**
1. Require the package using composer:

```
composer require thalles/baseadmin
```

2. (Laravel 7+ only) Require the laravel/ui package using composer:

```
composer require laravel/ui
```

### **2. Configuration**

1. Publish the custom adminlte config file:

```
php artisan vendor:publish --tag=config
```

2. Install the adminlte package using the command (For fresh laravel installations):

```
php artisan adminlte:install
```

- If something goes wrong, you will need to clear the config cache:
```
php artisan config:clear
```
For more informations about Laravel-AdminLTE, read the [documentation](https://github.com/jeroennoten/Laravel-AdminLTE)

3. Configure the UserRole Enum:
    - Criate the Enum
    ```
    php artisan make:enum UserRole
    ```
    - Now, you just need to add the possible values your enum can have as constants.
    ```
    <?php

        namespace App\Enums;

        use BenSampo\Enum\Enum;

        /**
        * @method static static OptionOne()
        * @method static static OptionTwo()
        * @method static static OptionThree()
        */
        final class UserRole extends Enum
        {
            const Administrator = 1;

            /**
            * Return the translated key name
            *
            * @param integer $value
            * @return string
            */
            public static function getTranslatedKey($value)
            {
                switch ($value) {
                    case self::Administrator:
                        $keyName = 'Administrador';
                        break;
                    default:
                        $keyName = 'Outro';
                        break;
                }

                return $keyName;
            }
        }
    ```

    For more informations about Enum, read the [documentation](https://github.com/BenSampo/laravel-enum)


4. Change Middleware Authenticate route to "admin.login":
```
<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {
            return route('admin.login');
        }
    }
}
```

5. Run Migrations and Seeders.

6. Publish routes and views:
    - Views: 
    ```
    php artisan vendor:publish --tag=views
    ```
    - Routes:
    ```
    php artisan vendor:publish --tag=routes
    ```


### **3. Usage**

To use the admin route file, you will need to register them. For that, on RouteServiceProvider.php file, insert the follow method:
```
/**
* Define the "admin" routes for the application.
*
* These routes all receive session state, CSRF protection, etc.
*
* @return void
*/
protected function mapAdminRoutes()
{
    Route::middleware('web')
            ->group(base_path('routes/admin.php'));
}
```

Before, map this method:
```
/**
* Define the routes for the application.
*
* @return void
*/
public function map()
{
    ...

    $this->mapAdminRoutes();
}
```
