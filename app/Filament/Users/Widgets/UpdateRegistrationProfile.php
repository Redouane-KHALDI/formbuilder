<?php

namespace App\Filament\Users\Widgets;

use App\Models\Country;
use App\Models\UserRegistration;
use Filament\Widgets\Widget;

class UpdateRegistrationProfile extends Widget
{
    protected static string $view = 'filament.users.widgets.update-registration-profile';

    public function getCountryValue(): int
    {
        $user_id = auth()->user()->getAuthIdentifier();
        $country_id = UserRegistration::where('user_id', $user_id)
            ->pluck('country_id')
            ->first();

        return $country_id ?? 0;
    }
}
