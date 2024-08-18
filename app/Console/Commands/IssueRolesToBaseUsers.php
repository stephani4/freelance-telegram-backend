<?php

namespace App\Console\Commands;

use App\Models\AuthUserResource;
use Illuminate\Console\Command;
use Spatie\Permission\Models\Role;

class IssueRolesToBaseUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:issue-roles-to-base-users';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Выдача ролей пользователям';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $usersRoles = $this->getBaseUsersRoles();
        foreach ($usersRoles as $userRole) {
            $user = AuthUserResource::where('telegram_id', $userRole['user'])
                ->first()
                ->user;

            $user->assignRole($userRole['role']);
        }
    }

    /**
     * @return array
     */
    private function getBaseUsersRoles() : array
    {
        return config('auth.issue_roles_users');
    }
}
