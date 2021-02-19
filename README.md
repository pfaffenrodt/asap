```terminal
  ,adPPYYba,  ,adPPYba,  ,adPPYYba,  8b,dPPYba,
  ""     `Y8  I8[    ""  ""     `Y8  88P'    "8a
  ,adPPPPP88   `"Y8ba,   ,adPPPPP88  88       d8
  88,    ,88  aa    ]8I  88,    ,88  88b,   ,a8"
  `"8bbdP"Y8  `"YbbdP"'  `"8bbdP"Y8  88`YbbdP"'
                                     88
                                     88
```
# as soon as published
What does it do. Provide a platform that you can easly share with your client and distribute multiple releases.

## Plans - Roadmap
* [x] Team support (thanks to jetstream)
* [ ] Concept
* [ ] 
* [ ] integration
    * [ ] gitlab
    * [ ] github

## Frameworks
* PHP 8
* [Laravel](https://laravel.com/)
* [inertiajs](https://inertiajs.com/)
* Vue
* Tailwindcss

## Dev Setup

### Requirements
* Make
* Docker

### Environment
initialize project. checkout vendor via docker
```
make init
# or
docker run --rm -v $(pwd):/opt -w /opt laravelsail/php80-composer:latest composer install
```
Using [sail](https://laravel.com/docs/8.x/sail) to boot or manage your environment

## License

The asap project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
