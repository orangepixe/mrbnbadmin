<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Service;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\ServiceResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\ServiceResource\RelationManagers;

class ServiceResource extends Resource
{
    protected static ?string $model = Service::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?int $navigationSort = 4;

    protected static ?string $modelLabel = "App service";

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Hidden::make('user_id')
                ->default(Auth::id()),
                Forms\Components\Section::make('Personal websites')
                    ->aside()
                    ->description('Enter your personal website details and the review service you wish to use. The display name will not be displayed on the website, it will be used only for identification purposes on the create property page.')
                    ->columns(12)
                    ->schema([
                        Forms\Components\TextInput::make('label')
                            ->label('Display name')
                            ->required()
                            ->placeholder('Trip Reviews #12')
                            ->columnSpan([
                                'sm' => 12,
                                'md' => 6,
                            ]),
                        Forms\Components\Select::make('appname')
                            ->label('App service')
                            ->required()
                            ->placeholder('Select app service')
                            ->options([
                                'tripadvisor' => 'Tripadvisor',
                                'tui' => 'TUI Holidays',
                                'airbnb' => 'Airbnb'
                            ])
                            ->columnSpan([
                                'sm' => 12,
                                'md' => 6,
                            ]),
                        Forms\Components\TextInput::make('appurl')
                            ->label('App URL')
                            ->required()
                            ->placeholder('https://clone-url.com/home/912939292')
                            ->columnSpanFull()
                            ->required(),
                        Forms\Components\Select::make('mode')
                            ->label('App mode')
                            ->reactive()
                            ->required()
                            ->placeholder('Select operating mode')
                            ->options([
                                'booking' => 'Booking mode',
                                'review' => 'Review mode',
                                'longterm' => 'Long-term mode',
                            ])
                            ->columnSpan([
                                'sm' => 12,
                                'md' => 6,
                            ]),
                        Forms\Components\TextInput::make('website_name')
                            ->label('Website')
                            ->required()
                            ->disabled(fn(Get $get) => $get('mode') !== 'review')
                            ->hidden(fn(Get $get) => $get('mode') !== 'review')
                            ->placeholder('Villas Reviews')
                            ->columnSpan([
                                'sm' => 12,
                                'md' => 8,
                            ]),
                        Forms\Components\FileUpload::make('website_logo')
                            ->image()
                            ->disabled(fn(Get $get) => $get('mode') !== 'review')
                            ->hidden(fn(Get $get) => $get('mode') !== 'review')
                            ->columnSpan([
                                'sm' => 12,
                                'md' => 6,
                            ])
                            ->imageResizeMode('cover')
                            ->panelAspectRatio('16:9')
                            ->panelLayout('integrated')
                            ->disk('cloudinary')
                            ->directory('misterbnb/logos'),
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('label')
                    ->label('Display name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('mode')
                    ->label('Mode')
                    ->formatStateUsing(fn($record) => ucfirst($record->mode)),
                Tables\Columns\TextColumn::make('appname')
                    ->label('Review service')
                    ->formatStateUsing(fn($record) => ucfirst($record->appname))
                    ->searchable(),
                Tables\Columns\TextColumn::make('appurl')
                    ->label('Clone URL')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->since(),
            ])
            ->defaultSort('id', 'desc')
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ReplicateAction::make(),
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
                ]),

            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageServices::route('/'),
        ];
    }
}
