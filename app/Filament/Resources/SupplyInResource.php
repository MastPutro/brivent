<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SupplyInResource\Pages;
use App\Models\SupplyIn;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Filters\Filter;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use AymanAlhattami\FilamentDateScopesFilter\DateScopeFilter;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\ForceDeleteAction;
use Filament\Tables\Actions\RestoreAction;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Actions\Action;

class SupplyInResource extends Resource
{
    protected static ?string $model = SupplyIn::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Brivent Management';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
            Select::make('product_id')
                ->label('Product')
                ->relationship('product', 'name')
                ->searchable()
                ->preload()
                ->required(),

            Forms\Components\TextInput::make('quantity')
                ->numeric()
                ->required()
                ->reactive(), // ← penting agar bisa trigger perhitungan

            Forms\Components\TextInput::make('price')
                ->label('Harga per Pcs')
                ->numeric()
                ->required()
                ->prefix('XFA')
                ->reactive()
                ->debounce(500)
                ->afterStateUpdated(function (\Filament\Forms\Set $set, $state, $get) {
                    $quantity = $get('quantity');
                    if ($quantity > 0) {
                        $set('total_price', $state * $quantity);
                    } else {
                        $set('total_price', null);
                    }
                }),

            Forms\Components\TextInput::make('total_price')
                ->label('Total Harga')
                ->numeric()
                ->prefix('XFA')
                ->reactive()
                ->debounce(500)
                ->afterStateUpdated(function (\Filament\Forms\Set $set, $state, $get) {
                    $quantity = $get('quantity');
                    if ($quantity > 0) {
                        $set('price', $state / $quantity);
                    } else {
                        $set('price', null);
                    }
                }),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('product.name')
                    ->label('Product')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('quantity')
                    ->label('Qty')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('price')
                    ->label('Harga/unit')
                    ->money('XFA')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Tanggal Masuk')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                Filter::make('custom_date_range')
                    ->label('Rentang Tanggal')
                    ->form([
                        DatePicker::make('from')->label('Dari'),
                        DatePicker::make('until')->label('Sampai'),
                    ])
                    ->query(function (Builder $query, array $data) {
                        return $query
                            ->when($data['from'], fn ($q, $date) => $q->whereDate('created_at', '>=', $date))
                            ->when($data['until'], fn ($q, $date) => $q->whereDate('created_at', '<=', $date));
                    }),

                DateScopeFilter::make('created_at')
                    ->label('Waktu Masuk'),

                TrashedFilter::make(), // << Tambahkan filter ini
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                DeleteAction::make(),
                RestoreAction::make(),
                ForceDeleteAction::make(),
                Action::make('print_barcodes')
                    ->label('Cetak Barcode')
                    ->url(fn ($record) => route('supply-in.barcodes.pdf', $record))
                    ->openUrlInNewTab()
                    ->icon('heroicon-o-printer'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                ]),
            ])
            ->modifyQueryUsing(fn (Builder $query) => $query->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]));
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSupplyIns::route('/'),
            'create' => Pages\CreateSupplyIn::route('/create'),
            'edit' => Pages\EditSupplyIn::route('/{record}/edit'),
        ];
    }
}
