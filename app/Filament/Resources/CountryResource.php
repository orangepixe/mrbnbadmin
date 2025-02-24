<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Country;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Filament\Resources\Resource;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Model;
use Filament\Tables\Columns\ImageColumn;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\CountryResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\CountryResource\RelationManagers;

class CountryResource extends Resource
{
    protected static ?string $model = Country::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static bool $shouldRegisterNavigation = false;

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
                ImageColumn::make('flag')
                    ->state(fn(Model $record) => "flags/" . ($record->flag ? $record->flag : 'NULL.png'))
                    //->circular()
                    ->disk('public')
                    ->width(45)
                    ->height(30)
                    ->extraImgAttributes(fn (Model $record): array => [
                        'alt' => "{$record->name} flag",
                        'loading' => 'lazy',
                    ])
                    ->checkFileExistence(false),
                TextColumn::make('name')
                    ->searchable()
                    ->description(fn (Model $record): string => $record->full_name),
                TextColumn::make('currency_code')
                    ->label('Currency')
                    ->state(fn (Model $record): string => $record->currency ? Str::ucfirst($record->currency) : 'N/A')
                    ->description(fn(Model $record) => ($record->currency_code ? $record->currency_code : 'N/A') . " " . ($record->currency_symbol ? $record->currency_symbol : '')),
                TextColumn::make('calling_code')
                    ->state(fn(Model $record) => "+" . $record->calling_code)
                    ->description(fn (Model $record): string => $record->iso_3166_2 . " | " . $record->iso_3166_3),
            ])
            ->filters([
                //
            ])
            ->actions([
                // Tables\Actions\ViewAction::make(),
                // Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                // Tables\Actions\BulkActionGroup::make([
                //     Tables\Actions\DeleteBulkAction::make(),
                // ]),
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
            'index' => Pages\ListCountries::route('/'),
            //'create' => Pages\CreateCountry::route('/create'),
            //'view' => Pages\ViewCountry::route('/{record}'),
            //'edit' => Pages\EditCountry::route('/{record}/edit'),
        ];
    }
}
