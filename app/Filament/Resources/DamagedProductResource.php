<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DamagedProductResource\Pages;
use App\Filament\Resources\DamagedProductResource\RelationManagers;
use App\Models\DamagedProduct;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Validation\Rule;

class DamagedProductResource extends Resource
{
    protected static ?string $model = DamagedProduct::class;

    protected static ?string $navigationIcon = 'heroicon-o-exclamation-circle';
    protected static ?string $navigationGroup = 'Brivent Management';
    protected static ?string $label = 'Damaged Products';
    protected static ?string $pluralLabel = 'Damaged Products';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('supply_in_barcode_id')
                    ->label('Barcode')
                    ->relationship('barcode', 'code')
                    ->searchable()
                    ->preload()
                    ->required()
                    ->hint(fn ($state) => \App\Models\SupplyInBarcode::find($state)?->damaged ? '⚠️ Barcode ini sudah rusak' : null)
                    ->disableOptionWhen(fn ($value) => \App\Models\SupplyInBarcode::find($value)?->damaged)
                    ->helperText('Pilih barcode unit yang rusak. Barcode yang sudah rusak tidak dapat dipilih.')
                    ->rules([
                        Rule::unique('damaged_products', 'supply_in_barcode_id'),
                    ]),

                Forms\Components\DatePicker::make('damaged_at')
                    ->label('Tanggal Rusak')
                    ->required(),

                Forms\Components\TextInput::make('reason')
                    ->label('Penyebab')
                    ->required(),

                Forms\Components\Textarea::make('notes')
                    ->label('Catatan')
                    ->rows(3),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('barcode.code')
                    ->label('Barcode')
                    ->searchable(),

                Tables\Columns\TextColumn::make('damaged_at')
                    ->label('Tanggal Rusak')
                    ->date(),

                Tables\Columns\TextColumn::make('reason')
                    ->label('Penyebab'),

                Tables\Columns\TextColumn::make('notes')
                    ->label('Catatan')
                    ->limit(30),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListDamagedProducts::route('/'),
            'create' => Pages\CreateDamagedProduct::route('/create'),
            'edit' => Pages\EditDamagedProduct::route('/{record}/edit'),
        ];
    }
}
