<?php

namespace Mlntn\Repository\Commands;

use Exception;
use Illuminate\Console\GeneratorCommand;
use Symfony\Component\Console\Input\InputOption;

class RepositoryMakeCommand extends GeneratorCommand {

  /**
   * The console command name.
   *
   * @var string
   */
  protected $name = 'make:repository';

  /**
   * The console command description.
   *
   * @var string
   */
  protected $description = 'Create a new repository class';

  /**
   * The type of class being generated.
   *
   * @var string
   */
  protected $type = 'Repository';

  /**
   * Get the stub file for the generator.
   *
   * @return string
   */
  protected function getStub() {
    return __DIR__ . '/stubs/repository.eloquent.stub';
  }

  /**
   * Get the stub file for the interface generator.
   *
   * @return string
   */
  protected function getInterfaceStub() {
    return __DIR__ . '/stubs/repository.interface.stub';
  }

  /**
   * @return void
   */
  public function fire() {
    $name = $this->parseName($this->getNameInput());

    try {
      $path = $this->getPath($name);
      $this->buildFile($name, $path, $this->getInterfaceStub());

      $ename = $this->parseName("Eloquent\\" . $this->getNameInput());
      $epath = $this->getPath($ename);
      $this->buildFile($ename, $epath, $this->getStub());
    }
    catch (Exception $e) {
      $this->error($this->type . ' already exists!');
      return;
    }

    $this->info($this->type.' created successfully. Make sure the following line is in your RepositoryServiceController.php');
    $this->info("\$this->app->bind('{$name}', '{$ename}');");
  }

  protected function buildFile($name, $path, $file) {
    if ($this->files->exists($path)) {
      throw new Exception("{$path} already exists!");
    }

    $this->makeDirectory($path);

    $stub = $this->files->get($file);

    $contents = $this->replaceNamespace($stub, $name)->replaceModelNamespace($stub, $name)->replaceClass($stub, $name);

    $this->files->put($path, $contents);
  }

  /**
   * Replace the class name for the given stub.
   *
   * @param  string  $stub
   * @param  string  $name
   * @return string
   */
  protected function replaceModelNamespace(&$stub, $name)
  {
    $model_ns = $this->input->getOption('model-namespace') ?: $this->getNamespace($name) . '\Model';

    $stub = str_replace('{{modelNamespace}}', $model_ns, $stub);

    return $this;
  }

  /**
   * Get the default namespace for the class.
   *
   * @param  string $rootNamespace
   * @return string
   */
  protected function getDefaultNamespace($rootNamespace) {
    return $rootNamespace . '\Repository';
  }

  /**
   * Get the console command options.
   *
   * @return array
   */
  protected function getOptions()
  {
    return array(
      array('model-namespace', null, InputOption::VALUE_OPTIONAL, 'Namespace of model classes'),
    );
  }

}
