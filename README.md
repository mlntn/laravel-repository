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
