<?php

namespace App\Http\Services\Telegram;

use App\Models\AuthUserResource;
use App\Models\User;

class UserService
{
    private $user;

    private User $userModal;

    private AuthUserResource $authUserResourceModal;

    public function __construct()
    {
        $this->userModal = new User();

        $this->authUserResourceModal = new AuthUserResource();
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function find(int $id) : self
    {
        $this->user = $this->userModal->find($id);

        return $this;
    }

    /**
     * @param int $telegramID
     * @return $this
     */
    public function findByTelegramId(int $telegramID) : self
    {
        $this->user = $this->authUserResourceModal
            ->with('user')
            ->where('telegram_id', $telegramID)
            ->first();

        return $this;
    }

    /**
     * @param array $filters
     * @return mixed
     */
    public function filtered(array $filters = []): mixed
    {
        return User::filter($filters)->with('roles')->paginate(10);
    }

    /**
     * @param User $user
     * @param array $data
     * @return void
     */
    public function update(User $user, array $data) : void
    {
        $user->fill($data)->save();
    }

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

}
