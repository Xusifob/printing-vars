## HOW TO PRINT NICELY YOUR VARS

###AngularJS

First step, you need to install bootstrap angular to your project

Bower :

````
 bower install angular-bootstrap
````

Documentation : https://angular-ui.github.io/bootstrap/

````
 angular.module('app',['ui.bootstrap'])
````

Then, download the file json.js and add it to your project

Don't forget to link it in your application index.html

````
 <script src="path/to/your/json.js"></script>
````

###PHP

For it to work, you need to install Bootstrap CSS/JS and jQuery

First step you need to download the var_dump.php file and insert it into your project

````
require_once 'path/to/your/var_dump.php';
````

Then, you need to configure your in_dev() function with your own ip address

After this, if you need to dump data, you can use the function vardump();

This will display the dump tab

![Var dump](/img/php-dump.png?raw=true "VarDump")