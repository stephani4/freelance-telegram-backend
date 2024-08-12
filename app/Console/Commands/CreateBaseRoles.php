<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Permission\Models\Role;

class CreateBaseRoles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:create-base-roles';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Создание базовых ролей';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $roles = $this->getBaseRoles();
        foreach ($roles as $role) {
            if (!Role::where('name', $role)->count()) {
                Role::create(['name' => $role]);
            }
        }
    }

    private function getBaseRoles() : array
    {
        return [
            'admin'
        ];
    }
}
