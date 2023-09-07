<?php

namespace App\Application\Actions\Balance;

use App\Application\Helper\RequestHelper;
use Psr\Http\Message\ResponseInterface as Response;

class ViewBalanceAction extends BalanceAction
{
    protected function action(): Response
    {
        $balances = $this->balanceRepository->getByUserId(
            userId: RequestHelper::getUserIdFromRequest($this->request)
        );
        return $this->respondWithData($balances);
    }
}