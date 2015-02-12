<?php

namespace Mlntn\Repository;

interface Repository {

  public function all($columns = array('*'));

  public function create(array $attributes);

  public function find($id, $columns = array('*'));

  public function update($id, array $input);

  public function delete($id);

}