<?php

namespace App\Http\Controllers\Api\CashCards;

use App\Http\Controllers\Controller;
use App\Http\Services\Telegram\CashCardService;
use App\Models\CashCard;
use Illuminate\Http\Request;

class CashCardsController extends Controller
{
    private CashCardService $cashCardService;

    public function __construct(CashCardService $cashCardService)
    {
        $this->cashCardService = $cashCardService;
    }

    /**
     * Получение списка карт пользователя
     *
     * @param Request $request
     * @return mixed
     */
    public function my(Request $request): mixed
    {
        $cards = $this->cashCardService->getCardsByUserId(auth('api')->user()->id);
        return response()->json($cards, 200);
    }
}
