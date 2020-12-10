# P5 OC DA/PHP - Symfony

Create your first blog with PHP


## Getting Started

These instructions will get you a copy of the project up and running on your local machine if you want to test it or develop something on it.


### Prerequisites

To make the project run you will need to install those things :

* [Laragon](https://laragon.org/download/)
* [PHP 7.4.11](https://www.php.net/releases/index.php)
* [Apache 2.4.35](http://archive.apache.org/dist/httpd/httpd-2.4.35.tar.gz)
* [MySQL 5.7.24](https://downloads.mysql.com/archives/get/p/23/file/mysql-5.7.24-winx64.zip)
* [Composer](https://getcomposer.org/download/)
* [Node.js & npm](https://nodejs.org/fr/)


### Installing

Follow those steps to make the projetc run on your machine

Clone the project :
```
git clone https://github.com/mathias73/Blog.git
```
Update composer :
```
composer update
```
Install npm packages :
```
npm i
```
### Database

You can download a database with data test here : 

[Blog database](https://drive.google.com/file/d/189oRdbs7TA4vJOhOhx8Wtx2VCiR-pU5C/view?usp=sharing)


You can edit Config.php with your database credentials : 

```php
class Config
{
    const DB_HOST = 'mysql:dbname=blog;host=127.0.0.1';
    const DB_USER = 'root';
    const DB_PASSWORD = '';
    const DB_OPTION = [\PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'];
}
```

## Local Test Mail

You can configure Laragon to test the contact form (it send a mail).

Foolow the instructions here : https://laragon.org/docs/mail-sender.html

![email](https://image.noelshack.com/fichiers/2020/49/6/1607181565-email.png)

## Built With

* [PHP](https://www.php.net/manual/fr/intro-whatis.php) - Programming language
* [Twig](https://twig.symfony.com/) - Template engine
* [Bootstrap](https://getbootstrap.com/) - CSS Framework
* [aos](https://michalsnik.github.io/aos/) - Animation JS library
* [TinyMCE](https://www.tiny.cloud/) - Text editor
* [Fontawesome](https://fontawesome.com/) - Icon library


## Versioning

For the versions available, see the [tags on this repository](https://github.com/mathias73/blog/tags). 


## Authors

* **Mathias Micheli** - *Student* - [Github](https://github.com/mathias73)

