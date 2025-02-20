<?php
namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Components\Grid;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Section;
use Filament\Tables\Columns\TextColumn;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;
    protected static ?string $navigationIcon = 'heroicon-o-cube';
    protected static ?string $navigationLabel = 'Produtos';
    protected static ?string $pluralLabel = 'Produtos';
    protected static ?string $modelLabel = 'Produto';

    protected static ?int $navigationSort = 2;
    protected static ?string $navigationGroup = 'Orçamentos';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make(2) // Divide os campos em duas colunas
                ->schema([
                    TextInput::make('name')
                        ->label('Nome do Produto')
                        ->required()
                        ->maxLength(255),

                    TextInput::make('ideal_price')
                        ->label('Preço Ideal')
                        ->numeric()
                        ->prefix('R$')
                        ->nullable(),
                ]),

                Forms\Components\RichEditor::make('description')
                    ->label('Descrição')
                    ->nullable()
                    ->columnSpanFull(), // Ocupa toda a largura abaixo
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Nome do Produto')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('description')
                    ->label('Descrição')
                    ->limit(50),

                TextColumn::make('ideal_price')
                    ->label('Preço Ideal')
                    ->money('BRL')
                    ->sortable(),

                TextColumn::make('created_at')
                    ->label('Criado em')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('updated_at')
                    ->label('Atualizado em')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
