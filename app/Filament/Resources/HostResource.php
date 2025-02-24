<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\Host;
use Filament\Tables;
use App\Models\Review;
use App\Models\Country;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Forms\Components;
use Filament\Resources\Resource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\HostResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\HostResource\RelationManagers;

class HostResource extends Resource
{
    protected static ?string $model = Host::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Components\Hidden::make('user_id')
                    ->default(Auth::id()),
                // BASIC INFORMATION
                Components\Section::make('Basic host information')
                    ->aside()
                    ->columns(3)
                    ->description('Basic information about the host. Be sure to include a detailed description about yourself.')
                    ->schema([
                        Components\Grid::make('contact')
                            ->schema([])->columnSpan([
                                'sm' => 12,
                                'md' => 2,
                            ])->schema([
                                Components\TextInput::make('name')
                                    ->label('Display name')
                                    ->required()
                                    ->placeholder('Jimmy')
                                    ->columnSpanFull(),
                                Components\Textarea::make('about')
                                    ->rows(2)
                                    ->label('About summary')
                                    ->placeholder('Write something about yourself')
                                    ->columnSpanFull(),
                                Components\TextInput::make('url')
                                    ->label('Host url')
                                    ->placeholder('Ex.: https://www.airbnb.com/users/show/14276099')
                                    ->helperText('If you want to direct the guest to an existing host url.')
                                    ->columnSpanFull(),
                            ]),
                        Components\FileUpload::make('avatar')
                            ->image()
                            ->columnSpan([
                                'sm' => 12,
                                'md' => 1,
                            ])
                            ->imageResizeMode('cover')
                            ->imageCropAspectRatio('1:1')
                            ->panelAspectRatio('1:1')
                            ->panelLayout('integrated')
                            ->disk('cloudinary')
                            ->directory('misterbnb/avatars'),
                    ]),
                    // REVIEWS
                    Components\Section::make('Host reviews')
                        ->aside()
                        ->columns(1)
                        ->description('Select some reviews for this host. Be sure to include all the reviews available for this host. Some reviews are AI generated so be sure to check them before you publish your property.')
                        ->schema([
                            Components\Select::make('reviews')
                                ->multiple()
                                ->default([3, 6, 10, 16, 18, 20, 25, 30])
                                ->native(false)
                                ->searchable()
                                ->preload()
                                ->options(Review::host()->pluck('content', 'id')->toArray()),
                            Components\Toggle::make('superhost')
                                ->reactive()
                                ->default(true)
                                ->inline(false)
                                ->columnSpanFull(),
                        ]),







            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name'),
                Tables\Columns\TextColumn::make('about')
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
            'index' => Pages\ListHosts::route('/'),
            'create' => Pages\CreateHost::route('/create'),
            'view' => Pages\ViewHost::route('/{record}'),
            'edit' => Pages\EditHost::route('/{record}/edit'),
        ];
    }
}
