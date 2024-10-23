<?php

namespace App\Filament\Pages;

use AllowDynamicProperties;
use App\Filament\Resources\FormFieldResource\Pages;
use App\Models\Country;
use App\Models\FormField;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Get;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

#[AllowDynamicProperties] class ManageForms extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.manage-forms';

    protected static ?string $navigationGroup = 'Registration Management';

    public $selectedCountry = null;

    public array $fields = [];

    public bool $showPreviewModal = false;

    public function mount()
    {
        $this->form->fill();
    }

    protected function getFormSchema(): array
    {
        return [
            Select::make('selectedCountry')
                ->label('Select Country')
                ->options(Country::pluck('name', 'id'))
                ->reactive()
                ->afterStateUpdated(fn ($state) => $this->loadFields($state)),
            Repeater::make('fields')
                ->schema([
                    TextInput::make('name')
                        ->required()
                        ->maxLength(255),
                    Select::make('type')
                        ->options([
                            'text'      => 'Text',
                            'password'  => 'Password',
                            'email'     => 'Email',
                            'textarea'  => 'Textarea',
                            'date'      => 'Date',
                            'dropdown'  => 'Dropdown',
                            'radio'     => 'Radio',
                            'checkbox'  => 'Checkbox',
                            'number'    => 'Number',
                            'file'      => 'File Upload',
                        ])
                        ->required()
                        ->live(),
                    Toggle::make('required')
                        ->required(),
                    Select::make('category')
                        ->options([
                            'general'   => 'General',
                            'identity'  => 'Identity',
                            'bank'      => 'Bank',
                        ])
                        ->required(),
                    TagsInput::make('options')
                        ->separator(',')
                        ->visible(fn (Get $get) => in_array($get('type'), ['dropdown', 'radio']))
                        ->required(),
                ])
                ->defaultItems(3)
                ->columns(2)
                ->addActionLabel('Add Field')
                ->visible(fn () => $this->selectedCountry !== null)
                ->cloneable()
        ];
    }

    public function loadFields($countryId): void
    {
        if ($countryId) {
            $this->fields = FormField::where('country_id', $countryId)->get()->toArray();
        } else {
            $this->fields = [];
        }
    }

    /**
     * @throws ValidationException
     */
    public function save(): void
    {
        $this->validate();

        DB::transaction(function () {
            FormField::where('country_id', $this->selectedCountry)->delete();

            foreach ($this->fields as $field) {
                FormField::create([
                    'country_id'    => $this->selectedCountry,
                    'name'          => $field['name'],
                    'type'          => $field['type'],
                    'required'      => $field['required'] ?? false,
                    'category'      => $field['category'],
                    'options'       => $field['options'] ?? null,
                ]);
            }
        });

        Notification::make()
            ->title('Form created successfully')
            ->success()
            ->send();
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListFormFields::route('/'),
            'create' => Pages\CreateFormField::route('/create'),
            'edit' => Pages\EditFormField::route('/{record}/edit'),
        ];
    }
}
