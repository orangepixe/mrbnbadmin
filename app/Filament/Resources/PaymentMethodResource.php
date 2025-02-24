<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\PaymentMethod;
use Filament\Forms\Components;
use Filament\Resources\Resource;
use Faker\Provider\ar_EG\Payment;
use Illuminate\Support\Facades\Auth;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\PaymentMethodResource\Pages;
use App\Filament\Resources\PaymentMethodResource\RelationManagers;

class PaymentMethodResource extends Resource
{
    protected static ?string $model = PaymentMethod::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?int $navigationSort = 5;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Components\Hidden::make('user_id')
                    ->default(Auth::id()),
                // BASIC INFORMATION
                Components\Section::make('Define your payment method')
                    ->aside()
                    ->columns(12)
                    ->description('Enter the basic information of the payment method. This information will be displayed on the website.')
                    ->schema([
                        Components\Select::make('gateway')
                            ->label('Payment gateway')
                            ->required()
                            ->native(false)
                            ->options([
                                'paypal' => 'PayPal',
                                'stripe' => 'Stripe',
                                'crypto' => 'Cryptocurrency',
                                'bank' => 'Bank transfer',
                            ])
                            ->columnSpan([
                                'sm' => 12,
                                'md' => 4,
                            ]),
                        Components\TextInput::make('label')
                            ->label('Public label')
                            ->required()
                            ->placeholder('#01 SEPA Bank Transfer')
                            ->columnSpan([
                                'sm' => 12,
                                'md' => 8,
                            ]),
                        Components\RichEditor::make('description')
                            ->label('Public description')
                            ->required()
                            ->placeholder('Enter a detailed description of the payment method')
                            ->columnSpanFull(),
                    ]),
                // INSTRUCTIONS
                Components\Section::make('Detailed instructions')
                    ->aside()
                    ->columns(12)
                    ->description('Enter the detailed instructions on how to use this payment method. This information will be displayed on the payment invoice and/or email sent to the customer.')
                    ->schema([
                        Components\TextArea::make('instructions')
                            ->label('Payment instructions')
                            ->required()
                            ->rows(3)
                            ->placeholder('Instruct your customers on how to use this payment method')
                            ->columnSpanFull(),
                    ]),
                // IMAGES
                Components\Section::make('Payment logo')
                    ->aside()
                    ->columns(1)
                    ->description('Minimum 1 image is required. Be sure to upload high-quality small logo or icon png file.')
                    ->schema([
                        Components\FileUpload::make('logo')
                            ->label('Payment gateway logo')
                            ->acceptedFileTypes(['image/png'])
                            ->required()
                            ->helperText('PNG file types only')
                            ->minFiles(1)
                            ->disk('cloudinary')
                            ->directory('misterbnb/payment-methods'),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('logo')->disk('cloudinary')
                    ->size(32)
                    ->extraImgAttributes(fn (): array => [
                        'alt' => 'Logo',
                        'loading' => 'lazy',
                    ]),
                TextColumn::make('label'),
                TextColumn::make('gateway'),
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
            'index' => Pages\ListPaymentMethods::route('/'),
            'create' => Pages\CreatePaymentMethod::route('/create'),
            'view' => Pages\ViewPaymentMethod::route('/{record}'),
            'edit' => Pages\EditPaymentMethod::route('/{record}/edit'),
        ];
    }
}
