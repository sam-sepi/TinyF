# TinyF

Easy PHP framework for small web applications

## Getting Started

git clone https://github.com/sam-sepi/TinyF.git

**TinyF** is a simple framework created to not rewrite the wheel when building a simple site with a private area.

## DOC

In the database folder the DbWrapper class manages the db connection and offers APIs for queries. The *getInstance* method returns a static instance of the class, evoked in the ModelWrapper class. ModelWrapper in the models folder is the contract stipulated between all models.

```php
namespace TinyF\Models;

use TinyF\Database\DbWrapper;

class ModelWrapper
{
    ///Db property for all models
    protected $db;

    public function __construct(
        string $dsn = null, string $user = null, string $password = null, array $options = null
    )
    {
        $this->db = DbWrapper::getInstance($dsn, $user, $password, $options);
    }
}

namespace TinyF\Models;

use TinyF\Models\ModelWrapper;

/** 
 *  @class UserModel
 *  
 */
class UserModel extends ModelWrapper
{ //[...]
```

The libraries folder contains libraries for various utilities such as session management, cookies or input and requests handling.

```php
$string = '<script>alert("Hello!")</script>';

$validation = new TinyF\Libraries\Validation;

echo $validation->getFilteredString($string);

$cookie = new TinyF\Libraries\Cookie;
$cookie->mycookie = 'cookievalue';
//reload
echo $cookie->mycookie; //out.: 'cookievalue'

$session = new TinyF\Libraries\Session;
$session->name = 'sessioname';
echo $_SESSION['name']; //out.: sessioname

$req = new TinyF\Libraries\Request;
echo $req->getMethod(); //out.: get
```

The *login.php* and *signin.php* files are available as examples or for a quick set up of an authentication and registration system on the site.

## Author
Sam Sepi - Initial work

## License
This project is licensed under the MIT License - see the LICENSE.md file for details
