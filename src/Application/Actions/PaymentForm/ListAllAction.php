<?php

namespace App\Application\Actions\PaymentForm;

use Psr\Http\Message\ResponseInterface as Response;

class ListAllAction extends PaymentFormAction
{
    protected function action(): Response
    {
        $paymentForms = $this->paymentFormRepository->findAll();
        return $this->respondWithData($paymentForms);
    }
}