<?php

  namespace App\Migration;

  use Doctrine\Migrations\Generator\ClassNameGenerator;

  class CustomMigrationGenerator extends ClassNameGenerator
  {
    public function generateClassName(string $namespace, ?string $name = null): string
    {
      $safeName = $name
          ? preg_replace('/[^A-Za-z0-9]/', '', ucwords($name))
          : 'Migration';

      return 'Version' . $namespace . '_' . $safeName;
    }
  }
