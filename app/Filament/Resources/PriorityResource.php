<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PriorityResource\Pages;
use App\Filament\Resources\PriorityResource\RelationManagers;
use App\Models\Priority;
use Filament\Forms;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PriorityResource extends Resource
{
    protected static ?string $model = Priority::class;

    protected static ?string $navigationIcon = 'heroicon-o-fire';
    protected static ?string $navigationLabel = 'Prioridades';
    protected static ?string $pluralLabel = 'Prioridades';
    protected static ?string $modelLabel = 'Prioridade';

    protected static ?int $navigationSort = 2;
    protected static ?string $navigationGroup = 'Cadastros';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make(2) // Divide os campos em 2 colunas
                ->schema([
                    TextInput::make('name')
                        ->label('Nome da Prioridade')
                        ->required()
                        ->unique(Priority::class, 'name')
                        ->maxLength(255),

                    Select::make('level')
                        ->label('Nível de Prioridade')
                        ->options([
                            1 => 'Baixa',
                            2 => 'Média',
                            3 => 'Alta',
                        ])
                        ->default(1)
                        ->required(),
                ]),

                Textarea::make('description')
                    ->label('Descrição')
                    ->rows(5)
                    ->nullable()
                    ->maxLength(255)
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Nome')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('description')
                    ->label('Descrição')
                    ->limit(50)
                    ->searchable(),

                TextColumn::make('level')
                    ->label('Nível')
                    ->formatStateUsing(fn ($state) => match ($state) {
                        1 => 'Baixa',
                        2 => 'Média',
                        3 => 'Alta',
                        default => 'Desconhecido',
                    })
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
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPriorities::route('/'),
            'create' => Pages\CreatePriority::route('/create'),
            'edit' => Pages\EditPriority::route('/{record}/edit'),
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
