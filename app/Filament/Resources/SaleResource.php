<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SaleResource\Pages;
use App\Models\Product;
use App\Models\Sale;
use Filament\Forms;
use Filament\Forms\Set;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Number;

class SaleResource extends Resource
{
    protected static ?string $model = Sale::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
{
    return $form
        ->schema([
            Section::make('Products')
                ->schema([
                    Repeater::make('items')
                        ->relationship()
                        ->schema([
                            Select::make('product_id')
                                ->relationship('product', 'name')
                                ->searchable()
                                ->preload()
                                ->required()
                                ->distinct()
                                ->disableOptionsWhenSelectedInSiblingRepeaterItems()
                                ->columnSpan(1)
                                ->reactive()
                                ->afterStateUpdated(function ($state, Forms\Set $set, Forms\Get $get) {
                                    // Fetch the product price when product is selected
                                    $product = Product::find($state);
                                    $unitPrice = $product?->price ?? 0;

                                    // Set unit price and update total based on quantity
                                    $set('unit_price', $unitPrice);
                                    $quantity = $get('quantity') ?? 0; // Default quantity to 0 if not set
                                    $set('total', $unitPrice * $quantity); // Recalculate total for item
                                }),

                            TextInput::make('quantity')
                                ->label('Quantity')
                                ->numeric()
                                ->default(0) // Start with quantity as 0
                                ->columnSpan(1)
                                ->reactive()
                                ->afterStateUpdated(function ($state, Forms\Set $set, Forms\Get $get) {
                                    // Ensure that quantity changes are handled properly
                                    $unitPrice = $get('unit_price') ?? 0;
                                    $quantity = $state ?? 0; // Default to 0 if null
                                    $set('total', $unitPrice * $quantity); // Recalculate the total for item

                                    // Recalculate subtotal after each item total update
                                    self::recalculateSubtotal($get, $set); // Static method call to recalculate subtotal
                                }),

                            TextInput::make('unit_price')
                                ->columnSpan(1)
                                ->label('Unit Price')
                                ->numeric()
                                ->disabled(),

                            TextInput::make('total')
                                ->label('Total')
                                ->columnSpan(1)
                                ->numeric()
                                ->disabled(),
                        ])
                        ->columns(4)
                        ->reactive()
                        ->afterStateUpdated(function (Forms\Get $get, Forms\Set $set) {
                            // Recalculate subtotal after any change in items
                            self::recalculateSubtotal($get, $set); // Static method call to recalculate subtotal
                        })
                        ->columnSpanFull(),
                ])
                ->columnSpan(8),

            Section::make('Cart Summary')
                ->schema([
                    Placeholder::make('subtotal')
                        ->label('Subtotal')
                        ->content(fn (Forms\Get $get) => Number::currency($get('subtotal') ?? 0, 'KES')),

                    Placeholder::make('tax')
                        ->label('Tax (16%)')
                        ->content(fn (Forms\Get $get) => Number::currency(($get('subtotal') ?? 0) * 0.16, 'KES')),

                    Placeholder::make('discount')
                        ->label('Discount')
                        ->content(fn (Forms\Get $get) => Number::currency($get('discount') ?? 0, 'KES')),

                    Placeholder::make('grand_total')
                        ->label('Grand Total')
                        ->content(function (Forms\Get $get) {
                            $subtotal = $get('subtotal') ?? 0;
                            $tax = $subtotal * 0.16;
                            $discount = $get('discount') ?? 0;

                            return Number::currency($subtotal + $tax - $discount, 'KES');
                        }),

                    Hidden::make('subtotal')->default(0),
                    Hidden::make('discount')->default(0),

                    Radio::make('payment_method')
                        ->label('Payment Method')
                        ->options([
                            'cash' => 'Cash',
                            'card' => 'Card',
                            'mobile' => 'Mobile Money',
                        ])
                        ->required(),
                ])
                ->columnSpan(4),
        ])
        ->columns(12);
}

// Static method to recalculate the subtotal
private static function recalculateSubtotal(Forms\Get $get, Forms\Set $set)
{
    // Recalculate subtotal by summing up all the item totals
    $items = $get('items') ?? [];
    $subtotal = array_sum(array_map(fn($item) => $item['total'] ?? 0, $items)); // Ensure sum of totals

    // Set the subtotal value
    $set('subtotal', $subtotal);
}









    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->label('Sale ID'),
                Tables\Columns\TextColumn::make('grand_total')->label('Total')->money(),
                Tables\Columns\TextColumn::make('payment_method')->label('Payment Method'),
                Tables\Columns\TextColumn::make('created_at')->dateTime(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSales::route('/'),
            'create' => Pages\CreateSale::route('/create'),
            'edit' => Pages\EditSale::route('/{record}/edit'),
        ];
    }
}
