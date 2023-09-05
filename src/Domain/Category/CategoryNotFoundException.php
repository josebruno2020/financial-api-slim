<?php

namespace App\Domain\Category;

use App\Domain\DomainException\DomainRecordNotFoundException;

class CategoryNotFoundException extends DomainRecordNotFoundException
{
    public $message = "Categoria informada não encontrada";
}