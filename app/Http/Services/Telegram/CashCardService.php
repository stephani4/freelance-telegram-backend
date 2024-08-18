<?php

namespace App\Http\Services\Telegram;

use App\Enums\FolderType;
use App\Models\CashCard;
use App\Models\Files;
use App\Models\User;

class CashCardService
{
    private CashCard $cashCard;

    public function __construct(CashCard $cashCard)
    {
        $this->cashCard = $cashCard;
    }

    /**
     * Создание новой карты наличных денег
     *
     * @param User $user
     * @param array $data
     * @return CashCard
     */
    public function create(User $user, array $data): CashCard
    {
        $cashCard = new CashCard();
        $cashCard->fill(array_merge($data, ['user_id' => $user->id]));
        $cashCard->save();
        return $cashCard;
    }

    /**
     * @param int $userId
     * @return mixed
     */
    public function getCardsByUserId(int $userId): mixed
    {
        return $this->cashCard->where('user_id', $userId)->get();
    }
}
