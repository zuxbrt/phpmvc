
# phpmvc
##### php version - 7.2.20
🚧 *work in progress* 🚧

### Setup
Create .config file in root directory, and configure it following the .config-example.
    
### cli usage:
> php cli --help

### Structure
    
    │
    ├── bootstrap                   # kernel class
    │    └── kernel.php                 *** used for capturing requests
    │
    ├── config                      # application configuration - in progress
    │    └── general.php                *** in progress
    │
    ├── core                        # project core files (database / request / response classes)
    │    ├── Console                    # Commands are registered here
    │    │      └── Commands.php              *** runs registered commands  
    │    ├── Database                   # database related classes
    │    │      ├── Connection.php            *** Generates PDO Object
    │    │      ├── Manager.php               *** Used for cli commands
    │    │      └── Mapper.php                *** Used for CRUD models functionality (in progress)
    │    │
    │    ├── Helpers                    # helpers with static methods
    │    │      └── Status.php              *** get response message according to HTTP status code  
    │    ├── Routing                    # url routing logic
    │    │      └── Resolver.php            *** Handles url calls to corresponding controller methods
    │    ├── autoload.php.              *** autoloads projects classes
    │    ├── Config.php                 *** gets parameters from .config file
    │    ├── Controller.php             *** abstract class, in progress
    │    ├── Model.php                  *** abstract class, in progress
    │    ├── Request.php                *** captures incoming requests, and resolves requested resource via Resolver
    │    └── Response.php               *** returns json response - with data, message and status code
    │
    ├── public                      # contains index.php and htaccess
    │    ├── .htaccess                  *** basic htaccess, with RewriteRule for index.php
    │    └── index.php                  *** calls autoload and intercepts requests with Kernel classs
    │
    ├── src                         # contains Controllers, Views and Models
    │    ├── Controllers                # Controllers directory
    │    │      ├── IndexController.php     *** Controller for root url "/"
    │    │      └── PostController.php      *** Controller for post resource, with get method ( in progress )
    │    ├── Models                     # Models directory
    │    │      └── Post.php                *** Model for Post resource
    │    └── Views                      # Views directory - in progress
    │           └── ExampleView.php         *** in progress
    │
    ├── .config-example             *** application configuration example (database connection)
    ├── .gitignore                  *** ignored files
    ├── cli                         *** command line interface ( for executing project commands - database operations for now )
    ├── database-config.php         *** array with tables and their columns
    └── README.md
    

