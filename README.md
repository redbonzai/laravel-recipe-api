

<p align="center"><img src="https://res.cloudinary.com/dtfbvvkyp/image/upload/v1566331377/laravel-logolockup-cmyk-red.svg" width="400"></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/d/total.svg" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/v/stable.svg" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/license.svg" alt="License"></a>
</p>

## About Laravel Recipe API

The recipe API is a full rest API with internal token authentication.  
It is a powerful boilerplate that features scalable architecture. 
All of the authentication is handled internally via Laravel Passport.


## How to scaffold the development environment

There is a bash file in the root ```bash scaffold_application.sh```
It is run like this: 
```bash 
bash scaffold_application.sh
```
It executes the following commands:
```bash 
   composer install && 
   npm install && 
   php artisan migrate --seed && 
   php artisan passport:install
``` 
This installs all composer and npm dependencies, runs all database scripts, and fills the 
tables with dummy data. 
The Laravel Passport oauth tables are also installed. 
Then it records the passport Access, and Grant tokens

## Installing Laravel Homestead

- **[Click here for documentation on installing Laravel Homestead](https://laravel.com/docs/6.x/homestead#installation-and-setup)**

Then ... 

### Create your ssh key pair

`ssh-keygen -t rsa -b 4096` // press enter on all the options /
make sure you add the key pair to your /Users/yourUserName/.ssh/ directory. 

### Modify your hosts file in order to have a domain:
```bash sudo nano /etc/hosts```\
and add the following line: 
```bash 
    192.168.10.10   recipe.test
```

### Configure the Homestead.yaml file: 

```bash
    ip: "192.168.10.10"
    memory: 2048
    cpus: 2
    provider: virtualbox
    
    authorize: ~/.ssh/nextlevel.pub
    
    keys:
        - ~/.ssh/nextlevel
    
    folders:
        - map: ~/Projects/laravel-recipe-api
          to: /home/recipeService
    
    sites:
        - map: recipe.test
          to: /home/recipeService/public
    
    databases:
        - recipeservice
    
    features:
        - mariadb: true
        - ohmyzsh: true
        - webdriver: false
    
    # ports:
    #     - send: 50000
    #       to: 5000
    #     - send: 7777
    #       to: 777
    #       protocol: udp
```

### Bash Profile Alias

Doing the following will allow you to access vagrant anywhere: 
```bash
function v() {
    echo "Executing Vagrant command: vagrant " $*
    ( cd ~/Homestead && vagrant $* && cd ~ )

}
```
then just enter commands like: `v up`, `v ssh`, `v reload`, etc ...

### Install the Postman Collection to test all the routes

[![Run in Postman](https://run.pstmn.io/button.svg)](https://app.getpostman.com/run-collection/b8d62b80c8fdb1e6e3bc)


## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please create a ticket at the following link: to Christian via [Github Ticket](https://github.com/redbonzai/laravel-recipe-api/issues). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-source software licensed under the [MIT license](https://opensource.org/licenses/MIT).
