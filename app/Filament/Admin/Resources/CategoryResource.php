<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\CategoryResource\Pages;
use App\Filament\Admin\Resources\CategoryResource\RelationManagers;
use App\Models\Category;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;




use Illuminate\Support\Str;

class CategoryResource extends Resource
{
    protected static ?string $model = Category::class;

    protected static ?string $navigationIcon = 'heroicon-o-folder';
    protected static ?string $navigationGroup = 'Content';



    protected static ?string $navigationLabel = 'Category';
    protected static ?int $navigationSort =1;


    public static function form(Forms\Form $form): Forms\Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('title')
                ->required()
                ->live(onBlur: true)
                ->afterStateUpdated(
                    fn($state, callable $set) =>
                    $set('slug', Str::slug($state))
                ),

            Forms\Components\TextInput::make('slug')
                ->required()
                ->unique(ignoreRecord: true),

            Forms\Components\RichEditor::make('description')
                ->required(),


            FileUpload::make('thumbnail')
                ->image()
                ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp', 'image/jpg'])
                ->maxSize(2048) // optional (2MB)
                ->required()
                ->directory('categories')
                ->visibility('public'),

            Forms\Components\Toggle::make('is_active')
                ->required(),

            Forms\Components\TextInput::make('canonical_url')
                ->required(),

            Forms\Components\TextInput::make('meta_title')
                ->required(),

            Forms\Components\Textarea::make('meta_description')
                ->required(),

            Forms\Components\Hidden::make('created_by')
                ->default(auth()->id()),
        ]);
    }

    public static function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('thumbnail')
                    ->square(),

                Tables\Columns\TextColumn::make('title')
                    ->searchable(),

                Tables\Columns\TextColumn::make('creator.name')
                    ->label('Created By')
                    ->formatStateUsing(
                        fn($record) =>
                        $record->creator->name . '(' . $record->creator->id . ')'
                    ),

                Tables\Columns\IconColumn::make('is_active')
                    ->label('Status')
                    ->boolean(),
            ])
             ->actions([
                // 👁 View – permission based
                Tables\Actions\ViewAction::make()
                    ->visible(fn () => auth()->user()?->can('view_categories') ?? false),

                // ✏ Edit – permission based
                Tables\Actions\EditAction::make()
                    ->visible(fn () => auth()->user()?->can('edit_categories') ?? false),

                // 🗑 Delete – permission + self delete block
                Tables\Actions\DeleteAction::make()
                    ->visible(fn ($record) =>
                        auth()->user()?->can('delete_categories ')

                    ),
                ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCategories::route('/'),
            'create' => Pages\CreateCategory::route('/create'),
            'edit' => Pages\EditCategory::route('/{record}/edit'),
        ];
    }


}
