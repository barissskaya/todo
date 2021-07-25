<?php

namespace App\Classes\Provider;

interface ProviderInterface {
  public function fetch();
  public function parseResponse(array $response) : array;
}
?>
