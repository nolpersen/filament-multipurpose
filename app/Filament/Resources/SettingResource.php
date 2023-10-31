<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SettingResource\Pages;
use App\Filament\Resources\SettingResource\RelationManagers;
use App\Models\Setting;
use App\Utilities\Constant;
use Closure;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Mohamedsabil83\FilamentFormsTinyeditor\Components\TinyEditor;
use Awcodes\Curator\Components\Forms\CuratorPicker;
use Awcodes\Curator\Components\Tables\CuratorColumn;

class SettingResource extends Resource
{
    protected static ?string $model = Setting::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Configuration';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('display_name')
                                        ->required()
                                        ->placeholder("My Setting")
                                        ->columns(1),
                Forms\Components\TextInput::make('name')
                                        ->required()
                                        ->placeholder("my_setting")
                                        ->maxLength(255)
                                        ->columns(1),
                
                Forms\Components\Select::make('type')
                                        ->options(Constant::$SETTING_TYPE)
                                        ->default('textinput')
                                        ->reactive()
                                        ->required()
                                        ->columns(1),

                // Forms\Components\TextInput::make('value')
                //                         ->required()
                //                         ->hidden(
                //                             fn (callable $get): bool => $get('type') != "textinput"
                //                         )
                //                         ->columnSpan("full"),

                // Forms\Components\Textarea::make('value')
                //                         ->rows(10)
                //                         ->required()
                //                         ->hidden(
                //                             fn (callable $get): bool => $get('type') != "textarea"
                //                         )
                //                         ->columnSpan("full"),
                
                // Forms\Components\Select::make('value')
                //                         ->required()
                //                         ->columnSpan("full"),
                //                         ->

                // TinyEditor::make('value')
                //     ->hidden(
                //         fn (callable $get): bool => $get('type') != "richtextbox"
                //     )
                //     ->minHeight(400)
                //     ->required()
                //     ->columnSpan("full"),
                // CuratorPicker::make('value')
                //             ->hidden(
                //                 fn (callable $get): bool => $get('type') != "fileupload"
                //             )
                //             ->pathGenerator(DatePathGenerator::class) // see path generators below
                //             ->listDisplay(false), // defaults to true

                Forms\Components\KeyValue::make('additional_info')
                            ->label('Options')
                            ->hidden(
                                fn (callable $get): bool => (($get('type') != "select") && ($get('type') != "checkbox") && ($get('type') != "radio"))
                            )
                            ->dehydrateStateUsing(fn ($state) => json_encode($state))
                            ->columnSpan("full"),
            ])->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
            ])
            ->filters([
                //
            ])
            ->actions([
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
            'index' => Pages\Settings::route('/'),
            'create' => Pages\CreateSetting::route('/create'),
            'edit' => Pages\EditSetting::route('/{record}/edit'),
        ];
    }    

    
}
