<?php

namespace Webkul\Locale\Filament\Resources;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Webkul\Locale\Filament\Resources\LocaleResource\Pages;
use Webkul\Locale\Models\Locale;

class LocaleResource extends Resource
{
    protected static ?string $model = Locale::class;

    protected static ?string $navigationIcon = 'heroicon-o-flag';

    public static function getNavigationLabel(): string
    {
        return 'Locales';
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('code')
                ->label('Code')
                ->required()
                ->maxLength(5),
            Forms\Components\TextInput::make('name')
                ->label('Name')
                ->required(),
            Forms\Components\TextInput::make('native_name')
                ->label('Native Name'),
            Forms\Components\TextInput::make('flag')
                ->label('Flag')
                ->helperText('Emoji or short code'),
            Forms\Components\Toggle::make('active')
                ->label('Active')
                ->default(true),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('code')->label('Code')->searchable(),
            Tables\Columns\TextColumn::make('name')->label('Name')->searchable(),
            Tables\Columns\TextColumn::make('native_name')->label('Native')->searchable(),
            Tables\Columns\TextColumn::make('flag')->label('Flag'),
            Tables\Columns\IconColumn::make('active')->boolean(),
        ])->actions([
            Tables\Actions\EditAction::make(),
            Tables\Actions\DeleteAction::make(),
        ])->bulkActions([
            Tables\Actions\DeleteBulkAction::make(),
        ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListLocales::route('/'),
            'create' => Pages\CreateLocale::route('/create'),
            'edit' => Pages\EditLocale::route('/{record}/edit'),
        ];
    }
}
