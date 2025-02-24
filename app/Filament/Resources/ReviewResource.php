<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Review;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Tables\Columns;
use Filament\Forms\Components;
use Filament\Resources\Resource;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Mokhosh\FilamentRating\Components\Rating;

use App\Filament\Resources\ReviewResource\Pages;
use Mokhosh\FilamentRating\Columns\RatingColumn;
use App\Filament\Resources\ReviewResource\RelationManagers;


class ReviewResource extends Resource
{
    protected static ?string $model = Review::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Components\Section::make('Basic reviewer information')
                    ->aside()
                    ->id('reviewsPage')
                    ->columns(12)
                    ->description('Enter the basic information of the reviewer. This information will be displayed on the website. There are two shortcodes available that can me used anytime: #hostname# and #propertyname#.')
                    ->schema([
                        Components\Hidden::make('user_id')->default(Auth::id()),
                        Components\TextInput::make('name')
                            ->label('Reviewer name')
                            ->required()
                            ->placeholder('Eg. John Doe')
                            ->columnSpan([
                                'sm' => 12,
                                'md' => 4,
                            ]),
                        Components\DatePicker::make('date')
                            ->label('Stay date')
                            ->required()
                            ->closeOnDateSelection()
                            ->placeholder('June 2021')
                            ->format('M Y')
                            ->displayFormat('F Y')
                            ->maxDate(now())
                            ->native(false)
                            ->columnSpan([
                                'sm' => 12,
                                'md' => 4,
                            ]),
                        Rating::make('rating')
                            ->default(4)
                            ->color('warning')
                            ->columnSpan([
                                'sm' => 12,
                                'md' => 4,
                            ]),
                        Components\TextInput::make('subject')
                            ->label('Subject')
                            ->required()
                            ->placeholder('Great stay!')
                            ->columnSpanFull(),
                        Components\Textarea::make('content')
                            ->id('reviewContent')
                            ->rows(3)
                            ->label('Review content')
                            ->required()
                            ->placeholder('Write your review here')
                            ->visibleOn(['view'])
                            ->columnSpan(12),
                        Components\Textarea::make('content')
                            ->id('reviewContent')
                            ->hiddenOn(['view'])
                            ->rows(3)
                            ->label('Review content')
                            ->required()
                            ->placeholder('Write your review here')
                            ->columnSpan(12)
                            ->helperText(new HtmlString("Shortcodes: <a onclick=\"MyFunction('hostname');return false;\" href=\"#\" class=\"text-warning-500\">#hostname#</a> <a onclick=\"MyFunction('propertyname');return false;\" href=\"#\" class=\"text-warning-500\">#propertyname#</a> <a onclick=\"MyFunction('type');return false;\" href=\"#\" class=\"text-warning-500\">#type#</a> <a onclick=\"MyFunction('bedrooms');return false;\" href=\"#\" class=\"text-warning-500\">#bedrooms#</a> <a onclick=\"MyFunction('bathrooms');return false;\" href=\"#\" class=\"text-warning-500\">#bathrooms#</a> <a onclick=\"MyFunction('beds');return false;\" href=\"#\" class=\"text-warning-500\">#beds#</a>")),
                        Components\TextInput::make('avatar')
                            ->label('Avatar URL')
                            ->reactive()
                            ->debounce(1000)
                            ->required()
                            ->default('https://ui-avatars.com/api/?background=random&name=John+Doe')
                            ->placeholder('Eg. https://ui-avatars.com/api/?background=random&name=John+Doe')
                            ->helperText(fn($state) => $state ? new HtmlString("<img src=\"{$state}\" alt=Image>") : new HtmlString("Insert any image URL to display an avatar. If you don't have an image, you can use <a target=\"_blank\" href=\"https://ui-avatars.com/\" class=\"text-warning-500\">UI Avatars</a> to generate one."))
                            ->columnSpan(12),
                        Components\Radio::make(name: 'type')
                            ->label('Review for ...')
                            ->default('property')
                            ->options([
                                'property' => 'Property',
                                'host' => 'Host'
                            ])
                            ->descriptions([
                                'property' => 'This review is for the property',
                                'host' => 'This review is for the host'
                            ])
                            ->columnSpan(12),

                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Columns\TextColumn::make('name')
                    ->formatStateUsing(fn(Model $record, $state) => $state . " - " . $record->subject)
                    ->description(fn($record) => str()->limit($record->content, 60))
                    ->limit(50),
                RatingColumn::make('rating')
                    ->color('warning'),
                Columns\TextColumn::make('type')
                    ->formatStateUsing(fn($record) => ucfirst($record->type)),
                Columns\TextColumn::make('date'),
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
            'index' => Pages\ListReviews::route('/'),
            'create' => Pages\CreateReview::route('/create'),
            'view' => Pages\ViewReview::route('/{record}'),
            'edit' => Pages\EditReview::route('/{record}/edit'),
        ];
    }
}
