<?php
/*
 * Secret key and Site key get on https://www.google.com/recaptcha
 * https://www.google.com/recaptcha/admin/site/557730029/setup
 * */
return [
    'secret' => env('CAPTCHA_SECRET'),
    'sitekey' => env('CAPTCHA_SITEKEY'),
    /**
     * @var string|null Default ``null``.
     * Custom with function name (example customRequestCaptcha) or class@method (example \App\CustomRequestCaptcha@custom).
     * Function must be return instance, read more in repo ``https://github.com/thinhbuzz/laravel-google-captcha-examples``
     */
    'request_method' => null,
    'options' => [
        'multiple' => false,
        'lang' => app()->getLocale(),
    ],
    'attributes' => [
        'theme' => 'light'
    ],
];