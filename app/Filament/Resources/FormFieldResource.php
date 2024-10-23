<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FormFieldResource\Pages;
use App\Filament\Resources\FormFieldResource\RelationManagers;
use App\Models\FormField;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class FormFieldResource extends Resource
{
    protected static ?string $model = FormField::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('country_id')
                    ->relationship('country', 'name')
                    ->required(),
                TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Select::make('type')
                    ->options([
                        'text'      => 'Text',
                        'number'    => 'Number',
                        'password'  => 'Password',
                        'date'      => 'Date',
                        'dropdown'  => 'Dropdown',
                        'radio'     => 'Radio',
                        'checkbox'  => 'Checkbox',
                        'textarea'  => 'Textarea',
                        'email'     => 'Email',
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
                    ->visible(fn(Get $get) => in_array($get('type'), ['dropdown', 'radio']))
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('country.name')->searchable(),
                TextColumn::make('name')->searchable(),
                TextColumn::make('type')->searchable(),
                IconColumn::make('required'),
                TextColumn::make('category')->searchable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('country')->relationship('country', 'name'),
                Tables\Filters\SelectFilter::make('type')->options([
                    'text'      => 'Text',
                    'number'    => 'Number',
                    'password'  => 'Password',
                    'date'      => 'Date',
                    'dropdown'  => 'Dropdown',
                    'checkbox'  => 'Checkbox',
                    'radio'     => 'Radio',
                    'textarea'  => 'Textarea',
                    'email'     => 'Email',
                    'file'      => 'File Upload',
                ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
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
