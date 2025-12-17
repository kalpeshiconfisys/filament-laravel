<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\BlogResource\Pages;
use App\Filament\Admin\Resources\BlogResource\RelationManagers;
use App\Models\Blog;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\BooleanColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class BlogResource extends Resource
{
    protected static ?string $model = Blog::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form) : Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('title')->required(),
            Forms\Components\TextInput::make('slug')->required(),
            Forms\Components\Textarea::make('excerpt')->required(),
            Forms\Components\Select::make('categories')
                ->multiple()
                ->relationship('categories', 'title')
                ->required(),
            Forms\Components\RichEditor::make('description')->required(),
            Forms\Components\FileUpload::make('thumbnail')->disk('public')->directory('blogs'),
            Forms\Components\FileUpload::make('featured_image')->disk('public')->directory('blogs'),
            Forms\Components\TextInput::make('meta_title'),
            Forms\Components\TextInput::make('meta_description'),
            Forms\Components\DateTimePicker::make('published_at'),
            Forms\Components\Select::make('status')
                ->options([
                    'draft' => 'Draft',
                    'published' => 'Published',
                    'archived' => 'Archived',
                ])
                ->default('draft')
                ->required(),
            Forms\Components\Toggle::make('is_featured')->default(false),
            Forms\Components\TextInput::make('view_count')->numeric(),
            Forms\Components\TextInput::make('reading_time')->numeric(),
            Forms\Components\TextInput::make('video_url'),
            Forms\Components\TextInput::make('location'),

        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
               ImageColumn::make('thumbnail')
    ->disk('public')
    ->visibility('public')
    ->height(60)
    ->width(60),

                TextColumn::make('title')->label('Title'),
                TextColumn::make('categories.name')->label('Categories'),
                TextColumn::make('user.username')->label('Created By'),
                TextColumn::make('created_at')->label('Created On'),
                TextColumn::make('updated_at')->label('Last Updated'),
                BooleanColumn::make('status')->label('Status'),
            ])
           ->actions([
                Tables\Actions\ViewAction::make()
                    ->visible(fn() => auth()->user()?->can('view_categories')),

                Tables\Actions\EditAction::make()
                    ->visible(fn() => auth()->user()?->can('edit_categories')),

                Tables\Actions\DeleteAction::make()
                    ->visible(fn() => auth()->user()?->can('delete_categories')),
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
            'index' => Pages\ListBlogs::route('/'),
            'create' => Pages\CreateBlog::route('/create'),
            'view' => Pages\ViewBlog::route('/{record}'),
            'edit' => Pages\EditBlog::route('/{record}/edit'),
        ];
    }
}
