<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PageResource\Pages;
use App\Filament\Resources\PageResource\RelationManagers;
use App\Models\Page;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Set;
use Illuminate\Support\Str;
use Mohamedsabil83\FilamentFormsTinyeditor\Components\TinyEditor;
use Awcodes\Curator\Components\Forms\CuratorPicker;
use Awcodes\Curator\Components\Tables\CuratorColumn;

class PageResource extends Resource
{
    protected static ?string $model = Page::class;

    protected static ?string $navigationIcon = 'heroicon-o-document';
    protected static ?string $navigationGroup = 'Blog';
    protected static ?int $navigationSort = 4;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                                        ->live()
                                        ->afterStateUpdated(fn (Set $set, ?string $state) => $set('slug', Str::slug($state)))
                                        ->required()
                                        ->maxLength(255),
                Forms\Components\TextInput::make('slug')
                ->required(),
                Forms\Components\Textarea::make('excerpt')
                                        ->required()
                                        ->columnSpan("full"),
                TinyEditor::make('body')
                ->minHeight(400)
                ->required()
                ->columnSpan("full"),

                Forms\Components\Select::make('status')
                ->required()
                ->options([
                    'ACTIVE' => 'Active',
                    'INACTIVE' => 'Inactive'
                ])
                ->native(false)
                ->columnSpan("full"),

                Forms\Components\TextInput::make('meta_keywords')->columnSpan("full"),

                Forms\Components\Textarea::make('meta_desc')->columnSpan("full"),
                
                CuratorPicker::make('image')
                            ->pathGenerator(DatePathGenerator::class) // see path generators below
                            ->listDisplay(false) // defaults to true
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                CuratorColumn::make('image')->size(80),
                Tables\Columns\TextColumn::make('title')->searchable(),
                Tables\Columns\TextColumn::make('slug')->searchable(),
                Tables\Columns\TextColumn::make('excerpt')->searchable(),
                Tables\Columns\TextColumn::make('status')->searchable(),
                Tables\Columns\TextColumn::make('updated_at')->searchable(),
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
            'index' => Pages\ListPages::route('/'),
            'create' => Pages\CreatePage::route('/create'),
            'edit' => Pages\EditPage::route('/{record}/edit'),
        ];
    }    
}
