<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserRegistrationResource\Pages;
use App\Filament\Resources\UserRegistrationResource\RelationManagers;
use App\Models\UserRegistration;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ViewColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class UserRegistrationResource extends Resource
{
    protected static ?string $model = UserRegistration::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('country.name')->searchable(),
                ViewColumn::make('data')
                    ->view('filament.columns.json-data')
                    ->searchable(
                        query: function (Builder $query, string $search): Builder {
                        return $query->where('data', 'like', "%{$search}%");
                    }),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListUserRegistrations::route('/'),
            'create' => Pages\CreateUserRegistration::route('/create'),
            'edit' => Pages\EditUserRegistration::route('/{record}/edit'),
        ];
    }
}
