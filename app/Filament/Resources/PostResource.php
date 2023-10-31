<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PostResource\Pages;
use App\Filament\Resources\PostResource\RelationManagers;
use App\Models\Post;
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


class PostResource extends Resource
{
    protected static ?string $model = Post::class;

    protected static ?string $navigationIcon = 'heroicon-o-newspaper';
    protected static ?string $navigationGroup = 'Blog';
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                                        ->live(onBlur: true)
                                        ->afterStateUpdated(fn (Set $set, ?string $state) => $set('seo_url', Str::slug($state)))
                                        ->required()
                                        ->maxLength(255),
                Forms\Components\TextInput::make('seo_url')->disabled(),
                Forms\Components\Select::make('categories')
                                        ->required()
                                        ->multiple()
                                        ->relationship('post_categories', 'name'),
                Forms\Components\Select::make('author')
                                        ->required()
                                        ->relationship('post_author', 'name'),
                Forms\Components\TextInput::make('short_desc')
                                        ->required()
                                        ->maxLength(255)
                                        ->columnSpan("full"),
                TinyEditor::make('content')
                ->minHeight(400)
                ->required()
                ->columnSpan("full"),
                Forms\Components\Select::make('status')
                ->required()
                ->options([
                    'DRAFT' => 'Draft',
                    'PUBLISH' => 'Published'
                ])
                ->native(false),
                Forms\Components\DateTimePicker::make('published_at'),
                Forms\Components\TextInput::make('meta_title'),
                Forms\Components\TextInput::make('meta_keyword'),
                Forms\Components\Textarea::make('meta_description')->columnSpan("full"),
                // Forms\Components\FileUpload::make('featured_image')
                // ->image()
                // ->imageEditor()
                // ->columnSpan("full"),
                CuratorPicker::make('featured_image')
                            // ->label(string $customLabel)
                            // ->buttonLabel(string | Htmlable | Closure $buttonLabel)
                            // ->color('primary') // defaults to primary
                            // ->outlined(true) // defaults to true
                            // ->size('sm') // defaults to md
                            // ->constrained(true) // defaults to false (forces image to fit inside the preview area)
                            ->pathGenerator(DatePathGenerator::class) // see path generators below
                            // ->lazyLoad(bool | Closure $condition) // defaults to true
                            ->listDisplay(false) // defaults to true
                            // // see https://filamentphp.com/docs/2.x/forms/fields#file-upload for more information about the following methods
                            // ->preserveFilenames()
                            // ->maxWidth()
                            // ->minSize(300)
                            // ->maxSize()
                            // ->rules()
                            // ->acceptedFileTypes()
                            // ->disk()
                            // ->visibility()
                            // ->directory()
                            // ->imageCropAspectRatio()
                            // ->imageResizeTargetWidth()
                            // ->imageResizeTargetHeight()
                            // ->multiple() // required if using a relationship with multiple media
                            // ->relationship(string $relationshipName, string 'titleColumnName')
                            // ->orderColumn('order') // only necessary to rename the order column if using a relationship with multiple media
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')->searchable(),
                CuratorColumn::make('featured_image'),
                Tables\Columns\TextColumn::make('short_desc')->searchable(),
                Tables\Columns\TextColumn::make('status')->searchable(),
                Tables\Columns\TextColumn::make('published_at')->searchable(),
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
            'index' => Pages\ListPosts::route('/'),
            'create' => Pages\CreatePost::route('/create'),
            'edit' => Pages\EditPost::route('/{record}/edit'),
        ];
    }    
}
