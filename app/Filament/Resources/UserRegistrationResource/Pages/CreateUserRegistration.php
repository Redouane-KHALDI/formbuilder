<?php

namespace App\Filament\Resources\UserRegistrationResource\Pages;

use App\Filament\Resources\UserRegistrationResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateUserRegistration extends CreateRecord
{
    protected static string $resource = UserRegistrationResource::class;
}
