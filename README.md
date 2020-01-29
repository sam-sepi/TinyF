# TinyF
Easy PHP framework for small web applications

# Doc
In *database* and *models* folder there are the files useful for connection and manipulation of the queries.

The *PdoWrapper* class implements interface *DbInterface* and is injected through the *ModelWrapper* into all models classes. 

The $db property, instance of PdoWrapper, in ModelWrapper is the contract established by *all models* that inherit from the class.

```php    
include('vendor\autoload.php');

$pdo = new TinyF\Database\PdoWrapper;
$user = new TinyF\Models\UserModel($pdo);

$u = $user->readUserById(1);
```

# Author
Sam Sepi - Initial work

# License
This project is licensed under the MIT License - see the LICENSE.md file for details