<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Livewire\Livewire;
use App\Models\Amenity;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Filament\Resources\Resource;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\FileUpload;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\AmenityResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\AmenityResource\RelationManagers;

class AmenityResource extends Resource
{
    protected static ?string $model = Amenity::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static bool $shouldRegisterNavigation = false;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->reactive()
                    ->debounce(700)
                    ->afterStateUpdated(function (Get $get, Set $set) {
                        if($get('name')) {
                            $str = Str::of($get('name'))->slug('_');
                            $set('value', $str);
                        }
                    }),
                TextInput::make('value'),
                FileUpload::make('icon')
                    ->image()
                    ->required()
                    ->label(__('Main image'))
                    ->disk('cloudinary')
                    ->directory('misterbnb/amenities')
                    ->default('https://res.cloudinary.com/dguu5sqgh/image/upload/v1708555615/00100-car-placeholder_jpjicb.png')
                    ->preserveFilenames()
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('icon')->disk('cloudinary')->size(32)
                    ->extraImgAttributes(fn (): array => [
                        'alt' => 'Icon',
                        'loading' => 'lazy',
                    ]),
                TextColumn::make('name'),
                TextColumn::make('value')->label('Slug'),
                TextColumn::make('created_at')->since(),
            ])
            ->defaultSort('id', 'desc')
            ->actions([
                Tables\Actions\ViewAction::make(),
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
            'index' => Pages\ListAmenities::route('/'),
            'create' => Pages\CreateAmenity::route('/create'),
            'view' => Pages\ViewAmenity::route('/{record}'),
            'edit' => Pages\EditAmenity::route('/{record}/edit'),
        ];
    }
}
