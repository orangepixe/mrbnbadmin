<?php

namespace App\Filament\Resources;

use App\Models\Host;
use Filament\Tables;
use App\Models\Review;
use App\Models\Amenity;
use App\Models\Country;
use App\Models\Service;
use Filament\Forms\Get;
use Filament\Forms\Set;
use App\Models\Currency;
use App\Models\Property;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use App\Models\PaymentMethod;
use Filament\Forms\Components;
use Filament\Resources\Resource;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use App\Filament\Resources\PropertyResource\Pages;


class PropertyResource extends Resource
{
    protected static ?string $model = Property::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        function mode($service = 1) {
           return $service ? (Service::find($service)->name === 'longterm') : false;
        }
        return $form
            ->schema([
                Components\Hidden::make('user_id')
                    ->default(Auth::id()),
                // BASIC INFORMATION
                Components\Section::make('Basic property information')
                    ->aside()
                    ->columns(12)
                    ->description(
                        fn (): HtmlString => new HtmlString(view('custom.basic'))
                    )
                    ->schema([
                        Components\TextInput::make('name')
                            ->label('Property title')
                            ->required()
                            ->placeholder('Enter the property title')
                            ->columnSpan([
                                'sm' => 12,
                                'md' => 8,
                            ]),
                        Components\Select::make('host_id')
                            ->label('Property host')
                            ->options(Host::pluck('name', 'id')->toArray())
                            ->columnSpan([
                                'sm' => 12,
                                'md' => 4,
                            ])
                            ->required(),
                        Components\TextInput::make('slug')
                            ->label('Property slug')
                            ->required()
                            ->placeholder('10001000 or amazing-view-penthouse-in-paris')
                            ->helperText('Automatically generate slug from the property title or use the left button to generate a slug based on random 8 digit numbers.')
                            ->default(fn() => rand(1000, 9999) . rand(1000, 9999))
                            ->columnSpan([
                                'sm' => 12,
                                'md' => 12,
                            ])
                            ->suffixAction(
                                Components\Actions\Action::make('sluggify')
                                        ->icon('heroicon-m-pencil')
                                        ->action(function (Set $set, Get $get) {
                                            $set('slug', Str::slug($get('name')). "-" . rand(1000, 9999));
                                        })
                                )
                            ->prefixAction(
                                Components\Actions\Action::make('numberify')
                                        ->icon('heroicon-m-finger-print')
                                        ->action(function (Set $set) {
                                            $set('slug', rand(1000, 9999) . rand(1000, 9999));
                                        })
                                ),
                        Components\Toggle::make('longterm')
                            ->reactive()
                            ->visible(false)
                            ->default(false),
                        Components\Select::make('service_id')
                            ->label('Application service')
                            ->reactive()
                            ->required()
                            ->native(false)
                            ->afterStateHydrated(function (Get $get, Set $set, $state) {
                                $current = $get('accommodation.size');
                                logger("afterStateHydrated " . $get('accommodation.size'));
                                if($state) {
                                    $set('longterm', (Service::find($state)->mode === 'longterm'));
                                    $set('accommodation.size', (Service::find($state)->mode === 'longterm') ? ($current ?? '60 m²') : ($current ?? 'entire'));
                                }
                            })
                            ->afterStateUpdated(function (Get $get, Set $set, $state) {
                                logger("afterStateUpdated " . $get('accommodation.size'));
                                $set('longterm', (Service::find($state)->mode === 'longterm'));
                                $set('accommodation.size', (Service::find($state)->mode === 'longterm') ? '60 m²' : 'entire');
                            })
                            ->columnSpan([
                                'sm' => 12,
                                'md' => 5,
                            ])
                            ->options(Service::pluck('label', 'id')->toArray()),
                        Components\TextInput::make('property_url')
                            ->reactive()
                            ->visible(fn(Get $get) => $get('service_id') ? (Service::find($get('service_id'))->mode === 'review') : false)
                            ->label('Redirect URL')
                            ->required()
                            ->placeholder('Ex.: https://www.example.com/property/12345')
                            ->default(fn() => rand(1000, 9999) . rand(1000, 9999))
                            ->columnSpan([
                                'sm' => 12,
                                'md' => 7,
                            ]),
                        Components\RichEditor::make('description')
                            ->label('Description')
                            ->required()
                            ->placeholder('Enter a detailed description of the property')
                            ->columnSpanFull(),
                    ]),
                // RATES
                Components\Section::make('Rates')
                    ->aside()
                    ->columns(12)
                    ->description('Enter the rates for the property. You can create a new currency in the currency management section.')
                    ->schema([
                        Components\Select::make('accommodation.currency')
                            ->label('Currency')
                            ->searchable()
                            ->required()
                            ->columnSpan([
                                'sm' => 6,
                                'md' => 4,
                            ])
                            ->options(Currency::pluck('name', 'id')->toArray())
                            ->default('EUR')
                            ->native(false),
                        Components\TextInput::make('rates.rate')
                            ->label(function (Get $get) {
                                return $get('longterm') ? 'Long-term rate' : 'Short-term rate';
                            })
                            ->suffix(function (Get $get) {
                                return $get('longterm') ? 'Monthly' : 'Nightly';
                            })
                            ->required()
                            ->columnSpan([
                                'sm' => 6,
                                'md' => 4,
                            ])
                            ->default(0)
                            ->numeric()
                            ->minValue(100)
                            ->placeholder(1200),
                        Components\TextInput::make('rates.deposit')
                            ->label('Security deposit')
                            ->numeric()
                            ->minValue(0)
                            ->default(0)
                            ->columnSpan([
                                'sm' => 6,
                                'md' => 4,
                            ])
                            ->placeholder(1200),
                        Components\TextInput::make('rates.installments')
                            ->label('Payment installments')
                            ->default(1)
                            ->numeric()
                            ->minValue(1)
                            ->columnSpan([
                                'sm' => 6,
                                'md' => 4,
                            ])
                            ->placeholder('Eg. 1'),
                        Components\TextInput::make('rates.service')
                            ->label('Service tax')
                            ->default(27)
                            ->numeric()
                            ->minValue(0)
                            ->columnSpan([
                                'sm' => 6,
                                'md' => 4,
                            ])
                            ->placeholder('Eg. 30'),
                    ]),
                // ACCOMMODATION
                Components\Section::make('Accommodation details')
                    ->aside()
                    ->columns(12)
                    ->description('Please provide key details about the accommodation to help potential tenants understand its features and requirements. Specify the type of home, size, and capacity, including the number of bedrooms, beds, and bathrooms. Set the maximum number of tenants allowed and the minimum rental duration. Choose a cancellation policy and currency for transactions. Lastly, select the accepted payment methods to ensure a smooth booking process.')
                    ->schema([
                        Components\Select::make('accommodation.type')
                            ->label('Home type')
                            ->required()
                            ->options([
                                'apartment' => 'Apartment',
                                'house' => 'House',
                                'guesthouse' => 'Guesthouse',
                                'villa' => 'Villa',
                                'loft' => 'Loft',
                                'boat' => 'Boat',
                            ])
                            ->default('apartment')
                            ->native(false)
                            ->columnSpan([
                                'sm' => 6,
                                'md' => 3,
                            ]),
                        Components\Select::make('accommodation.size')
                            ->label('Home size')
                            ->required()
                            ->disabled(fn(Get $get) => $get('longterm'))
                            ->hidden(fn(Get $get) => $get('longterm'))
                            ->default('entire')
                            ->options([
                                'entire' => 'Entire place',
                                'private' => 'Private place',
                                'shared' => 'Shared space'
                            ])
                            ->columnSpan([
                                'sm' => 6,
                                'md' => 3,
                            ])
                            ->native(false),
                        Components\TextInput::make('accommodation.size')
                            ->label('Home size')
                            ->default('60 m²')
                            ->disabled(fn(Get $get) => !$get('longterm'))
                            ->hidden(fn(Get $get) => !$get('longterm'))
                            ->placeholder('60 m²')
                            ->columnSpan([
                                'sm' => 6,
                                'md' => 3,
                            ]),
                        Components\TextInput::make('accommodation.guests')
                            ->label(fn(Get $get) => $get('longterm') ? 'Max tenants' : 'Max guests')
                            ->default(5)
                            ->required()
                            ->minValue(1)
                            ->numeric()
                            ->columnSpan([
                                'sm' => 6,
                                'md' => 3,
                            ])
                            ->placeholder('Eg. 5'),
                        Components\TextInput::make('accommodation.minimum')
                            ->label(fn(Get $get) => $get('longterm') ? 'Min months' : 'Min nights')
                            ->default(5)
                            ->numeric()
                            ->required()
                            ->minValue(1)
                            ->columnSpan([
                                'sm' => 6,
                                'md' => 3,
                            ])
                            ->placeholder('Eg. 5'),

                        Components\TextInput::make('accommodation.bedrooms')
                            ->default(2)
                            ->numeric()
                            ->columnSpan([
                                'sm' => 6,
                                'md' => 3,
                            ])
                            ->placeholder('Eg. 2'),
                        Components\TextInput::make('accommodation.beds')
                            ->label('Total beds')
                            ->default(2)
                            ->required()
                            ->minValue(0)
                            ->numeric()
                            ->columnSpan([
                                'sm' => 6,
                                'md' => 3,
                            ])
                            ->placeholder('Eg. 2'),
                        Components\TextInput::make('accommodation.sofas')
                            ->default(0)
                            ->numeric()
                            ->required()
                            ->minValue(0)
                            ->columnSpan([
                                'sm' => 6,
                                'md' => 3,
                            ])
                            ->placeholder('Eg. 2'),
                        Components\TextInput::make('accommodation.bathrooms')
                            ->default(1)
                            ->numeric()
                            ->columnSpan([
                                'sm' => 6,
                                'md' => 3,
                            ])
                            ->required()
                            ->minValue(0)
                            ->placeholder('Eg. 1'),
                        Components\Select::make('accommodation.policy')
                            ->label('Cancellation policy')
                            ->required()
                            ->columnSpan([
                                'sm' => 12,
                                'md' => 4,
                            ])
                            ->options([
                                'flexible' => 'Flexible',
                                'moderate' => 'Moderate',
                                'strict' => 'Strict',
                            ])
                            ->default('flexible')
                            ->native(false),

                        Components\Select::make('payment_methods')
                                ->required()
                                ->multiple()
                                ->native(false)
                                ->searchable()
                                ->preload()
                                ->columnSpan([
                                    'sm' => 12,
                                    'md' => 8,
                                ])
                                ->options(PaymentMethod::pluck('label', 'id')->toArray())
                    ]),
                // IMAGES
                Components\Section::make('Property images')
                    ->aside()
                    ->columns(1)
                    ->description('Upload a minimum of 4 property images to give potential guests a clear idea of what to expect. Only JPG images are accepted.')
                    ->schema([
                        Components\FileUpload::make('images')
                            ->label('Images')
                            ->image()
                            ->multiple()
                            ->columnSpanFull()
                            ->required()
                            ->minFiles(1)
                            ->disk('cloudinary')
                            ->panelLayout('grid')
                            ->directory('misterbnb/homes'),
                    ]),

                // LOCATION
                Components\Section::make('Property location')
                    ->aside()
                    ->columns(4)
                    ->description('Enter the full address details to accurately pinpoint the property’s location. Provide the street address, city, and state to ensure clarity. Latitude and longitude coordinates help with precise map positioning. This information is essential for tenants to find and assess the property easily.')
                    ->schema([
                        Components\Textarea::make('location.address')
                            ->label('Address')
                            ->required()
                            ->columnSpanFull()
                            ->default('2-4 Av. Octave Gréard, 75007 Paris')
                            ->placeholder('Eg. 2-4 Av. Octave Gréard, 75007 Paris')
                            ->helperText('Enter the property address you want to show on the listing.'),
                        Components\TextInput::make('location.city')
                            ->label('City')
                            ->required()
                            ->columnSpan([
                                'sm' => 2,
                                'md' => 1,
                            ])
                            ->default('Paris')
                            ->placeholder('Eg. Paris'),
                        Components\TextInput::make('location.state')
                            ->label('State')
                            ->columnSpan([
                                'sm' => 2,
                                'md' => 2,
                            ])
                            ->default('Île-de-France')
                            ->placeholder('Eg. Île-de-France'),
                        Components\TextInput::make('location.zip')
                            ->label('Zip code')
                            ->default('75007')
                            ->columnSpan([
                                'sm' => 2,
                                'md' => 1,
                            ])
                            ->placeholder('Eg. 75007'),
                        Components\Select::make('location.country')
                            ->label('Country')
                            ->native(false)
                            ->searchable()
                            ->preload()
                            ->default('France')
                            ->required()
                            ->columnSpan([
                                'sm' => 2,
                                'md' => 2,
                            ])
                            ->options(Country::pluck('name', 'full_name')->toArray()),
                        Components\Grid::make('latlng')
                            ->schema([
                                Components\TextInput::make('location.lat')
                                    ->label('Latitude')
                                    ->required()
                                    ->default(48.8588443)
                                    ->columnSpan([
                                        'sm' => 2,
                                        'md' => 2,
                                    ])
                                    ->placeholder('Enter the property latitude'),
                                Components\TextInput::make('location.lng')
                                    ->label('Longitude')
                                    ->required()
                                    ->default(2.2943506)
                                    ->columnSpan([
                                        'sm' => 2,
                                        'md' => 2,
                                    ])
                                    ->placeholder('Enter the property longitude'),
                            ])->columnSpanFull()->columns(4)
                    ]),

                // AMENITIES
                Components\Section::make('Amenities')
                    ->aside()
                    ->columns(1)
                    ->description('Select the amenities available in the property. Be sure to include all the amenities available for this property.')
                    ->schema([
                        Components\Select::make('amenities')
                            ->required()
                            ->multiple()
                            ->columnSpanFull()
                            ->default(['cctv', 'bathtub', 'air_conditioner', 'coffee_maker', 'curtains', 'dishwasher', 'eco_friendly'])
                            ->native(false)
                            ->searchable()
                            ->preload()
                            ->options(Amenity::pluck('name', 'value')->toArray())
                    ]),
                // REVIEWS
                Components\Section::make('Property reviews')
                    ->aside()
                    ->columns(1)
                    ->description('Select some reviews for this property. Be sure to include all the reviews available for this property. Some reviews are AI generated so be sure to check them before you publish your property.')
                    ->schema([
                        Components\Select::make('reviews')
                            ->required()
                            ->multiple()
                            ->default([1, 2, 4, 5, 7, 8, 9, 11])
                            ->native(false)
                            ->searchable()
                            ->columnSpanFull()
                            ->preload()
                            ->options(Review::property()->pluck('subject', 'id')->toArray())
                    ]),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('images')
                    ->disk('cloudinary')
                    ->limit(3)
                    ->square()
                    ->checkFileExistence(false)
                    ->limitedRemainingText()
                    ->wrap()
                    ->extraImgAttributes(['loading' => 'lazy']),
                Tables\Columns\TextColumn::make('name')
                    ->label('Property name')
                    ->copyMessage('Property link as been copied to your clipboard.')
                    ->formatStateUsing(fn(Model $record, $state) =>  str()->limit(str()->upper($record->service->appname . " - " . $state), 60))
                    ->copyableState(fn (Model $record): string => $record->service->appurl . $record->slug)
                    ->description(fn (Model $record): string => str()->limit(($record->service->appurl . $record->slug), 60)),
                Tables\Columns\TextColumn::make('location.address')
                    ->label('Location')
                    ->copyable()
                    ->copyMessage('Property link as been copied to your clipboard.')
                    ->copyableState(fn (Model $record): string => $record->service->appurl . $record->slug)
                    ->formatStateUsing(fn($state) => str()->limit($state, 25))
                    ->description(fn($record) => $record->location['lat'] . ", " . $record->location['lat']),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dates')
                    ->formatStateUsing(fn($state) => "created " . $state->since())
                    ->description(fn($record) => "updated " . $record->updated_at->since()),
            ])
            ->defaultSort('id', 'desc')
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\ReplicateAction::make()
                        ->mutateRecordDataUsing(function (array $data): array {
                            $data['slug'] = is_numeric($data['slug'])? rand(1000, 9999) . rand(1000, 9999) : $data['slug'] . '-'. rand(1000, 9999);
                            return $data;
                        }),
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

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProperties::route('/'),
            'create' => Pages\CreateProperty::route('/create'),
            'view' => Pages\ViewProperty::route('/{record}'),
            'edit' => Pages\EditProperty::route('/{record}/edit'),
        ];
    }
}
