<?php

namespace App\Domain\Enums;

enum GroupInvitationStatusEnum: string
{
    case PENDING = 'pending';
    case ACCEPTED = 'accepted';
    case RECUSED = 'recused';
}