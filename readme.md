
# phpmvc
##### php version - 7.2.20
🚧 *work in progress* 🚧

### Setup
Create .config file in root directory, and configure it following the .config-example.
    
### cli usage:
> php cli --help

### Postman docs:
https://documenter.getpostman.com/view/4336607/TVRdBBuz

### Structure
    
    │
    ├── bootstrap                   # kernel class
    │    └── kernel.php                 
    │
    ├── config                      # application configuration - in progress
    │    └── container.php   
    │    └── parameters.php 
    │    └── services.php              
    │
    ├── core                        # project core files
    │    ├── Console                    # commands
    │    │      └── Commands.php                
    │    ├── Database                   # database related classes
    │    │      ├── Instance.php
    │    │      ├── Manager.php
    │    │      ├── Mapper.php
    │    │      └── MySql.php
    │    │
    │    ├── Exceptions                 # exceptions
    │    │      ├── ContainerException.php
    │    │      ├── ParameterNotFoundException.php
    │    │      └── ServiceNotFoundException.php
    │    │
    │    ├── Helpers                    # helpers
    │    │      └── Status.php      
    │    │
    │    ├── Interfaces                 # interfaces
    │    │      ├── Database
    │    │      │      └── ConnectionInterface.php
    │    │      ├── Exceptions
    │    │      │      ├── ContainerExceptionInterface.php
    │    │      │      └── NotFoundExceptionInterface.php
    │    │      └── ContainerInterface.php
    │    │        
    │    ├── Reference                 # references
    │    │      ├── AbstractReference.php
    │    │      ├── ParameterReference.php
    │    │      └── ServiceReference.php
    │    │
    │    ├── Routing                    # url routing logic
    │    │      └── Resolver.php            *** Handles url calls
    │    │
    │    ├── autoload.php.              *** autoloads projects classes
    │    ├── Config.php                 *** gets parameters from .config file
    │    ├── Container.php              *** DI
    │    ├── Controller.php             *** abstract class for controllers
    │    ├── Request.php                *** captures incoming requests
    │    ├── Response.php               *** returns json response
    │    └── Template.php               *** templating engine for returning html
    │
    │
    ├── public                      # contains index.php and htaccess
    │    ├── .htaccess                  *** basic htaccess, with RewriteRule for index.php
    │    └── index.php                  *** calls autoload & kernel
    │
    ├── src                         # contains Controllers, Views and Models
    │    ├── Controllers                # Controllers directory
    │    │      ├── IndexController.php     *** Controller for root url "/"
    │    │      └── PostController.php      *** Controller for "post" resource
    │    ├── Models                     # Models directory
    │    │      └── Post.php                *** Model for Post resource
    │    └── Views                      # Views directory
    │           ├── Cache                   # cached views
    │           ├── index.html              *** view for index
    │           └── layout.html             *** html layout
    │
    ├── .config-example             *** application configuration example (database connection)
    ├── .gitignore                  *** ignored files
    ├── cli                         *** command line interface (php cli)
    ├── database-config.php         *** array with tables and their columns
    └── README.md
    

