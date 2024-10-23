<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\FormField;
use App\Models\User;
use App\Models\UserRegistration;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;


class UserRegistrationController extends Controller
{
    /**
     * @param Request $request
     * @return void
     */
    public function createUser (Request $request): void
    {
        $user = new User([
            'name'      => $request->input('name'),
            'email'     => $request->input('email'),
            'password'  => bcrypt($request->input('password')),
        ]);
        $user->save();
    }

    /**
     * @param Request $request
     * @param $user_id
     * @return void
     */
    public function updateUser(Request $request, $user_id)
    {
        $user = User::findOrFail($user_id);
        $user->name = $request->get('name');
        $user->email = $request->get('email');
        $user->password = $request->get('password');
        $user->save();
    }

    /**
     * @return mixed
     */
    public function getLatestUserId(): mixed
    {
        return  User::max('id');
    }

    /**
     * @param Request $request
     * @param string $operation
     * @return array
     */
    public function getValidatedRules(Request $request, string $operation): array
    {
        $countryId = $request->get('country_id');
        $country = Country::findOrFail($countryId);
        $formFields = $country->formFields;

        $validatedData = [];

        foreach ($formFields as $field) {
            $fieldType = $field->type;
            $fieldName = $field->name;
            $required = $field->required ? 'required|' : '';
            switch ($fieldType) {
                case 'text':
                case 'textarea':
                case 'number':
                    $validatedData[$fieldName] = $required . 'string|max:255';
                    break;
                case 'date':
                    $validatedData[$fieldName] = $required . 'date|max:255';
                    break;
                case 'checkbox':
                    $validatedData[$fieldName] = $required . 'boolean';
                    break;
                case 'email':
                    if ($operation === 'store') {
                        $validatedData[$fieldName] = 'required|string|email|max:255|unique:users';
                    } else {
                        $validatedData[$fieldName] = 'required|string|email|max:255';
                    }
                    break;
                case 'password':
                    if ($operation === 'store') {
                        $validatedData[$fieldName] = 'required|string|min:4';
                    } else {
                        $validatedData[$fieldName] = 'nullable|string|min:4';
                    }
                    break;
                case 'file':
                    $validatedData[$fieldName] = $required . 'file|max:2048';
                    break;
                default:
                    $validatedData[$fieldName] = $required . 'nullable|string';
                    break;
            }
        }

        return $validatedData;
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $validatedData = $this->getValidatedRules($request, 'store');

        $request->validate($validatedData);
        // Create the user
        if (function_exists($this->createUser($request))) {
            $this->createUser($request);
        }

        $user_id = $this->getLatestUserId();
        $userRegistration = new UserRegistration();
        $userRegistration->fill($validatedData);
        $userRegistration->data = $request->except('country_id', '_token');
        $userRegistration->country_id = $request->get('country_id');
        $userRegistration->user_id = $user_id;
        $userRegistration->save();

        $user = User::latest()->first();
        Auth::login($user);

        return redirect('/users/login')->with('success', 'Registration submitted successfully!');
    }

    /**
     * @param $countryId
     * @return Factory|View|Application
     */
    public function register($countryId)
    {
        $country = Country::findOrFail($countryId);
        $formFields = $country->formFields->groupBy('category');
        return view('forms.register', compact('country', 'formFields'));
    }

    /**
     * @param $country_id
     * @return Factory|View|Application|RedirectResponse|Redirector
     */
    public function edit($country_id)
    {
        if (!auth()->check()){
            return redirect('/users/login');
        }

        $user_id = auth()->id();

        $userRegistration = UserRegistration::where('user_id', $user_id)->firstOrFail();

        $country = Country::findOrFail($country_id);

        $formFields = FormField::where('country_id', $country->id)->get();

        $jsonData = is_array($userRegistration->data) ? $userRegistration->data : json_decode($userRegistration->data, true);

        return view('forms.edit', compact('userRegistration', 'country', 'formFields', 'jsonData'));
    }

    /**
     * @param Request $request
     * @return Application|RedirectResponse|Redirector
     */
    public function update(Request $request)
    {
        $validatedData = $this->getValidatedRules($request, 'update');

        $request->validate($validatedData);

        try {

            if (!auth()->check()){
                return redirect("/users/login");
            }

            $user_id = auth()->id();
            $userRegistration = UserRegistration::where('user_id', $user_id)->firstOrFail();
            $data = $request->except(['country_id', 'user_id', '_method', '_token']);

            foreach ($request->all() as $key => $value) {
                if ($key !== 'country_id' && $key !== 'user_id' && $key !== '_method' && $key !== '_token') {
                    $data[$key] = $value;
                }
            }

            $userRegistration->country_id = $request->country_id;
            $userRegistration->user_id = $request->user_id;
            $userRegistration->data = $data;
            $userRegistration->save();

            // Update user modal
            if (function_exists($this->updateUser($request, $user_id))) {
                $this->updateUser($request, $user_id);
            }

            return redirect()->route('forms.edit', $userRegistration->country_id)->with('success', 'User  registration updated successfully.');

        }catch (\Exception $e) {
            return redirect()->route('forms.edit')->with('error', 'An error occurred while updating the user registration. Please try again.');
        }
    }
}
