<?php

namespace App\Domain\Category;

use App\Domain\DomainException\DomainException;
use App\Domain\DomainException\DomainRecordNotFoundException;

class CategoryDeleteNotAllowedException extends DomainException
{
    public $message = "Não é permitido remover esta categoria";
}