<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\FormField;
use App\Models\User;
use App\Models\UserRegistration;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;

class FormController extends Controller
{
    /**
     * @return Factory|View|Application
     */
    public function index()
    {
        $countries = Country::select('id', 'name')->get();
        return view('forms.index', compact('countries'));
    }
}
