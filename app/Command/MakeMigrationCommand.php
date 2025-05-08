<?php

  namespace App\Command;

  use App\Migration\CustomMigrationGenerator;
  use Symfony\Component\Console\Attribute\AsCommand;
  use Symfony\Component\Console\Command\Command;
  use Symfony\Component\Console\Input\InputArgument;
  use Symfony\Component\Console\Input\InputInterface;
  use Symfony\Component\Console\Output\OutputInterface;

  #[AsCommand(
      name: 'make:migration:custom',
      description: 'Creates a custom-named Doctrine migration with a readable class name.'
  )]
  class MakeMigrationCommand extends Command
  {
    public function __construct(
        private CustomMigrationGenerator $nameGenerator
    ) {
      parent::__construct();
    }

    protected function configure(): void
    {
      $this->addArgument('name', InputArgument::REQUIRED, 'Descriptive migration name (e.g. AddUserStatusColumn)');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
      $timestamp = date('YmdHis');
      $name = $input->getArgument('name');
      $className = $this->nameGenerator->generateClassName($timestamp, $name);

      $filePath = __DIR__ . '/../../migrations/' . $className . '.php';

      $template = <<<PHP
<?php

declare(strict_types=1);

namespace migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class $className extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema \$schema): void
    {
        // TODO: Write your migration here
    }

    public function down(Schema \$schema): void
    {
        // TODO: Revert your migration here
    }
}
PHP;

      file_put_contents($filePath, $template);

      $output->writeln("✅ Created migration: $filePath");

      return Command::SUCCESS;
    }
  }
