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
    public function find(int $id): self
    {
        $this->user = $this->userModal->find($id);

        return $this;
    }

    /**
     * Поиск пользователя по Telegram ID
     *
     * @param int $telegramID
     * @return UserService
     */
    public function findByTelegramId(int $telegramID): self
    {
        $this->user = $this->authUserResourceModal
            ->where('telegram_id', $telegramID)
            ->with(['user' => function ($query) {
                return $query->with('roles');
            }])
            ->first();

        return $this;
    }

    /**
     * Регистрация из Telegram
     *
     * @param int $telegramID
     * @param array $data
     * @return $this
     */
    public function registerFromTelegram(int $telegramID, array $data): self
    {
        $existResource = $this
            ->authUserResourceModal
            ->where('telegram_id', $telegramID)
            ->first();

        $user = $existResource
            ? $this->findByTelegramId($telegramID)->getUser()->user
            : new User;

        if (!$existResource) {
            // Создаем нового пользователя
            $user->name = $data['first_name'] . ' '. $data['last_name'];
            $user->save();

            $user->resource()->create([
                'user_id' => $user->id,
                'telegram_id' => $telegramID,
            ]);
        } else {
            // Обновляем данные пользователя
            $user
                ->fill(array_merge($data, ['register' => true]))
                ->save();
        }

        $this->user = $user;
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
    public function update(User $user, array $data): void
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

    /**
     * @return bool
     */
    public function isExistUser() : bool
    {
        return !!$this->user;
    }
}
