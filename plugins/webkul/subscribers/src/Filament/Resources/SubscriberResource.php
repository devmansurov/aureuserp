<?php

namespace Webkul\Subscriber\Filament\Resources;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Webkul\Subscriber\Filament\Resources\SubscriberResource\Pages;
use Webkul\Subscriber\Models\Subscriber;
use Webkul\Locale\Models\Locale;

class SubscriberResource extends Resource
{
    protected static ?string $model = Subscriber::class;

    protected static ?string $navigationIcon = 'heroicon-o-user';

    public static function getNavigationLabel(): string
    {
        return 'Subscribers';
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Details')
                ->schema([
                    Forms\Components\Select::make('gender')
                        ->options(['male' => 'Male', 'female' => 'Female'])
                        ->required(),
                    Forms\Components\DatePicker::make('birthdate'),
                    Forms\Components\Toggle::make('is_land_near_yard'),
                    Forms\Components\Toggle::make('is_land_rented'),
                    Forms\Components\Toggle::make('has_barn'),
                    Forms\Components\Toggle::make('has_pasture'),
                    Forms\Components\Toggle::make('has_dehkan_farm'),
                    Forms\Components\Toggle::make('is_test_team'),
                    Forms\Components\TextInput::make('land_total')->numeric()->step('0.01'),
                    Forms\Components\TextInput::make('excel_row_id')->numeric(),
                    Forms\Components\Toggle::make('is_location_verified'),
                    Forms\Components\Toggle::make('is_rejected'),
                    Forms\Components\TextInput::make('status'),
                ])->columns(2),
            Forms\Components\Section::make('Translations')
                ->schema([
                    Forms\Components\Tabs::make('translations')
                        ->tabs(
                            Locale::where('active', true)->get()->map(function ($locale) {
                                return Forms\Components\Tabs\Tab::make($locale->code)
                                    ->label($locale->flag . ' ' . strtoupper($locale->code))
                                    ->schema([
                                        Forms\Components\TextInput::make("translations.{$locale->code}.full_name")
                                            ->label('Full Name'),
                                        Forms\Components\TextInput::make("translations.{$locale->code}.company")
                                            ->label('Company'),
                                        Forms\Components\TextInput::make("translations.{$locale->code}.position")
                                            ->label('Position'),
                                        Forms\Components\TextInput::make("translations.{$locale->code}.source")
                                            ->label('Source'),
                                        Forms\Components\Textarea::make("translations.{$locale->code}.notes")
                                            ->label('Notes'),
                                        Forms\Components\TextInput::make("translations.{$locale->code}.village")
                                            ->label('Village'),
                                        Forms\Components\TextInput::make("translations.{$locale->code}.dehkan_farm_name")
                                            ->label('Dehkan Farm Name'),
                                        Forms\Components\TextInput::make("translations.{$locale->code}.temp_district")
                                            ->label('Temp District'),
                                        Forms\Components\TextInput::make("translations.{$locale->code}.temp_jamoat")
                                            ->label('Temp Jamoat'),
                                    ])->columns(2);
                            })->toArray()
                        )
                        ->persistTabInQueryString(),
                ])
                ->columnSpan('full'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->label('ID')->sortable(),
                Tables\Columns\TextColumn::make('full_name')
                    ->label('Full Name')
                    ->getStateUsing(fn (Subscriber $record) => $record->translations->where('locale', app()->getLocale())->first()?->full_name)
                    ->searchable(),
                Tables\Columns\TextColumn::make('gender'),
                Tables\Columns\TextColumn::make('status'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSubscribers::route('/'),
            'create' => Pages\CreateSubscriber::route('/create'),
            'edit' => Pages\EditSubscriber::route('/{record}/edit'),
        ];
    }
}
