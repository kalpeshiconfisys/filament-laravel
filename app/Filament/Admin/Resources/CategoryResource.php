<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\CategoryResource\Pages;
use App\Models\Category;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\FileUpload;
use Illuminate\Support\Str;

class CategoryResource extends Resource
{
    protected static ?string $model = Category::class;

    protected static ?string $navigationIcon = 'heroicon-o-archive-box';
    protected static ?string $navigationGroup = 'Content';
    protected static ?string $navigationLabel = 'Category';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form->schema([

            Forms\Components\TextInput::make('title')
                ->required()
                ->live(onBlur: true)
                ->afterStateUpdated(
                    fn ($state, callable $set) =>
                        $set('slug', Str::slug($state))
                ),


            Forms\Components\TextInput::make('slug')
                ->required()
                ->unique(ignoreRecord: true),

            Forms\Components\RichEditor::make('description')
                ->required(),

            // ✅ FIXED FILE UPLOAD (MOST IMPORTANT)
            FileUpload::make('thumbnail')
                ->label('Thumbnail')
                ->image()
                ->disk('public')              // 🔥 REQUIRED
                ->directory('categories')     // storage/app/public/categories
                ->visibility('public')
                ->imagePreviewHeight('150')
                ->required(),

            Forms\Components\Toggle::make('is_active')
                ->required(),

            Forms\Components\TextInput::make('canonical_url')
                ->required(), 

            Forms\Components\TextInput::make('meta_title')
                ->required(),

            Forms\Components\Textarea::make('meta_description')
                ->required(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([

            // ✅ FIXED IMAGE COLUMN
            Tables\Columns\ImageColumn::make('thumbnail')
                    ->label('Thumbnail')
                    ->disk('public')
                    ->visibility('public')
                    ->square()
                    ->size(60),

                Tables\Columns\TextColumn::make('title')
                    ->searchable(),
                Tables\Columns\IconColumn::make('is_active')
                    ->boolean(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->visible(fn () => auth()->user()?->can('view_categories')),

                Tables\Actions\EditAction::make()
                    ->visible(fn () => auth()->user()?->can('edit_categories')),

                Tables\Actions\DeleteAction::make()
                    ->visible(fn () => auth()->user()?->can('delete_categories')),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListCategories::route('/'),
            'create' => Pages\CreateCategory::route('/create'),
            'edit'   => Pages\EditCategory::route('/{record}/edit'),
        ];
    }

}
