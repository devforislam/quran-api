- [Install Package](#install-package)
- [Import Quran Database](#quran-database)
- [Install Passport for Auth](#install-passport)
- [Features](./feature.md)
- [Download Api Collection](#download-api-collection)
- [Api Documentation](https://documenter.getpostman.com/view/5323572/SWLk3QwX?version=latest)

#### Install package
Install `devforislam/quran-api` via Composer package manager:

    composer require devforislam/quran-api

Add `DevForIslam\QuranApi\Supports\Favoritable` trait to `App\User` model:

    <?php

    namespace App;

    use Illuminate\Contracts\Auth\MustVerifyEmail;
    use Illuminate\Foundation\Auth\User as Authenticatable;
    use Illuminate\Notifications\Notifiable;
    use DevForIslam\QuranApi\Supports\Favoritable;

    class User extends Authenticatable
    {
        use Favoritable, Notifiable;
    }

Migrate the migrations

    php artisan migrate

#### Quran Database

Download the [quran-database](https://drive.google.com/open?id=1tFiGX2k0RvZijyQQBaLFvVAsoSEfN34W) and import to your database.

#### Install Passport

We used [laravel/passport](https://laravel.com/docs/6.x/passport) for api authentication.
You can install Passport via the Composer package manager:

    composer require laravel/passport

Migrate passport migrations:

    php artisan migrate

Install passport:

    php artisan passport:install

Add the `Laravel\Passport\HasApiTokens `trait to your `App\User` model.

    <?php

    namespace App;

    use Illuminate\Foundation\Auth\User as Authenticatable;
    use Illuminate\Notifications\Notifiable;
    use Laravel\Passport\HasApiTokens;

    class User extends Authenticatable
    {
        use HasApiTokens, Favoritable, Notifiable;
    }
    
Now set `passport` as authentication driver in `config/auth.php`

    'guards' => [
        'web' => [
            'driver' => 'session',
            'provider' => 'users',
        ],

        'api' => [
            'driver' => 'passport',
            'provider' => 'users',
        ],
    ],
#### Download API Collection

Download the post [api-collection](https://drive.google.com/open?id=1vwopSRAXmu7dB4926kpFSLP2D5fb06pb). Now, set the `url` and `token` as postman [environment variable](https://learning.getpostman.com/docs/postman/variables-and-environments/variables/). The value of `token` will be user's `access_token`. To see th API documentation click [here](https://documenter.getpostman.com/view/5323572/SWLk3QwX?version=latest).

> You are most welcome to contribute in this project or You have any suggestion email me to  [devforislam@gmail.com](mailto:devforislame@gmail.com) or [mahbub.rucse@gmail.com](mailto:mahbub.rucse@gmail.com). 

