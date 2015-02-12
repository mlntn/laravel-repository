# Laravel Repository Tools

### Getting Started

Register the `make:repository` command in app/Console/Kernel.php in the `$commands` property:
```php
'Mlntn\Repository\Commands\RepositoryMakeCommand',
```

You will need to create a RepositoryServiceController.php file in app\Providers. Here's what the file should look like:

```php
<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider {

  public function register() {
  
  }

}
```

Register the provider in app/config.php:

```php
'App\Providers\RepositoryServiceProvider',
```		

When you generate a repository, you will be provided with a binding that you need to add to the register method of RepositoryServiceProvider.

### Okay, then what?
Then you can move some logic out of your controllers and into your repository classes.

Laravel can magically inject your repository into your controller, if you tell it to:
```php
public function some_method($id, MyNewRepository $repo) {
  $item = $repo->find($id);
  // ...
}
```

### That's great, but why?
Separation of concerns, mostly. Your controller should be to-the-point and shouldn't be so tightly coupled to your model.