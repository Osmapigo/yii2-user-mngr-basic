CD project
===============================

This project has been developed for ClickDelivery Backend Software Developer Test.

Based on Yii2 Advanced template.

Aditional libraries installed trought Composer:

moonlandsoft/yii2-phpexcel => PHPOffice Wrapper to import and export excel files
yiisoft/yii2-authclient    => Yii2 library to OAuth, OAuth2 authentications. Used in Facebook login

Installation: 

Enable apache rewrite engine:
    a2enmod rewrite

Clone the repository.
    git clone https://github.com/Osmapigo/yii2-user-mngr-basic osmapigo

Give properly permissions to project folder.

Run the DML in your MySQL instance.

DIRECTORY STRUCTURE
-------------------

```
common
    config/              contains shared configurations
    mail/                contains view files for e-mails
    models/              contains model classes used in both backend and frontend
console
    config/              contains console configurations
    controllers/         contains console controllers (commands)
    migrations/          contains database migrations
    models/              contains console-specific model classes
    runtime/             contains files generated during runtime
frontend
    assets/              contains application assets such as JavaScript and CSS
    config/              contains frontend configurations
    controllers/         contains Web controller classes
    models/              contains frontend-specific model classes
    runtime/             contains files generated during runtime
    views/               contains view files for the Web application
    web/                 contains the entry script and Web resources
    widgets/             contains frontend widgets
vendor/                  contains dependent 3rd-party packages
environments/            contains environment-based overrides
tests                    contains various tests for the advanced application
```
