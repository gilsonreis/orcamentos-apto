<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BudgetResource\Pages;
use App\Filament\Resources\BudgetResource\RelationManagers;
use App\Models\Budget;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class BudgetResource extends Resource
{
    protected static ?string $model = Budget::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-check';
    protected static ?string $navigationLabel = 'Orçamentos';
    protected static ?string $pluralLabel = 'Orçamentos';
    protected static ?string $modelLabel = 'Orçamento';

    protected static ?int $navigationSort = 1;
    protected static ?string $navigationGroup = 'Orçamentos';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Informações Gerais')
                    ->schema([
                        TextInput::make('name')
                            ->label('Nome do Orçamento')
                            ->required()
                            ->maxLength(255),

                        Select::make('status')
                            ->label('Status')
                            ->options([
                                'PENDING'     => 'Pendente',
                                'APPROVED'    => 'Aprovado',
                                'DENIED'      => 'Negado',
                                'RECEIVED'    => 'Recebido',
                                'CANCELED'    => 'Cancelado',
                                'IN_PROGRESS' => 'Em andamento',
                                'COMPLETED'   => 'Concluído',
                            ])
                            ->default('PENDING')
                            ->required(),
                        DatePicker::make('due_date')
                            ->label('Data de Vencimento')
                            ->nullable(),
                    ])
                    ->columns(3),

                Section::make('Detalhes do Orçamento')
                    ->schema([
                        Grid::make(3)
                            ->schema([
                                Select::make('supplier_id')
                                    ->label('Fornecedor')
                                    ->relationship('supplier', 'name')
                                    ->searchable()
                                    ->preload()
                                    ->required(),

                                Select::make('category_id')
                                    ->label('Categoria')
                                    ->relationship('category', 'name')
                                    ->searchable()
                                    ->preload()
                                    ->required(),
                                Select::make('priority_id')
                                    ->label('Prioridade')
                                    ->relationship('priority', 'name')
                                    ->preload()
                                    ->searchable()
                                    ->required(),
                            ]),
                        Textarea::make('description')
                            ->label('Descrição')
                            ->nullable()
                            ->maxLength(500),
                    ]),

                Section::make('Valores e Pagamento')
                    ->schema([
                        Grid::make(3)
                            ->schema([
                                TextInput::make('price')
                                    ->label('Valor Total')
                                    ->numeric()
                                    ->prefix('R$')
                                    ->required(),

                                TextInput::make('stalement')
                                    ->label('Número de Parcelas')
                                    ->numeric()
                                    ->default(1)
                                    ->required(),

                                TextInput::make('stalement_value')
                                    ->label('Valor da Parcela')
                                    ->numeric()
                                    ->prefix('R$')
                                    ->default(0)
                                    ->required(),
                            ]),

                        DatePicker::make('stalement_start')
                            ->label('Início do Pagamento')
                            ->nullable(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Nome do Orçamento')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('supplier.name')
                    ->label('Fornecedor')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('category.name')
                    ->label('Categoria')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('priority.name')
                    ->label('Prioridade')
                    ->sortable(),

                TextColumn::make('price')
                    ->label('Valor Total')
                    ->money('BRL')
                    ->sortable(),

                TextColumn::make('due_date')
                    ->label('Data de Vencimento')
                    ->date('d/m/Y')
                    ->sortable(),

                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->sortable(),

                TextColumn::make('stalement')
                    ->label('Parcelas')
                    ->sortable(),

                TextColumn::make('stalement_value')
                    ->label('Valor da Parcela')
                    ->money('BRL')
                    ->sortable(),

                TextColumn::make('stalement_start')
                    ->label('Início do Pagamento')
                    ->date('d/m/Y')
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

                TextColumn::make('deleted_at')
                    ->label('Excluído em')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
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
            'index' => Pages\ListBudgets::route('/'),
            'create' => Pages\CreateBudget::route('/create'),
            'edit' => Pages\EditBudget::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
