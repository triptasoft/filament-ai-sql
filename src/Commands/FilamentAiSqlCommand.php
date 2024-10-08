<?php

namespace Triptasoft\FilamentAiSql\Commands;

use Illuminate\Console\Command;

class FilamentAiSqlCommand extends Command
{
    public $signature = 'filament-ai-sql:install';

    public $description = 'Install';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
