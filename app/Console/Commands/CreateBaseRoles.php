<?php

namespace App\Console\Commands;

use App\Enums\Roles;
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
            if (!Role::where('name', $role['name'])->count()) {
                Role::create(['name' => $role, 'ru_name' => $role['ru_name']]);
            }
        }
    }

    private function getBaseRoles(): array
    {
        return [
            [
                'name' => Roles::ADMIN->value,
                'ru_name' => 'Администратор',
            ],
            [
                'name' => Roles::TASK_MODERATOR->value,
                'ru_name' => 'Модератор задач',
            ]
        ];
    }
}
