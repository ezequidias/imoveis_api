<?php

namespace App\Enums;

enum PropertyStatus: string
{
    case AVAILABLE = 'available';
    case RENTED = 'rented';
    case SOLD = 'sold';
}