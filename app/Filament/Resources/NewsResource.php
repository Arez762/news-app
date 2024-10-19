<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\News;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\DateTimePicker;
use App\Filament\Resources\NewsResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\NewsResource\RelationManagers;

class NewsResource extends Resource
{
    protected static ?string $model = News::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
{
    return $form
        ->schema([
            TextInput::make('name')
                ->required()
                ->label('Judul'),
            Textarea::make('content')
                ->required()
                ->label('Konten'),
            FileUpload::make('thumbnail')
                ->image()
                ->required()
                ->label('Thumbnail'),
            Select::make('category_id')
                ->relationship('category', 'name') // Menampilkan nama kategori
                ->required()
                ->label('Kategori'),
            Select::make('user_id') // Menampilkan input untuk memilih author
                ->relationship('user', 'name') // Menggunakan relasi 'user' untuk mengambil 'name' dari model User
                ->required()
                ->label('Author'),
            TextInput::make('slug')
                ->disabled()
                ->unique(News::class, 'slug', ignoreRecord: true)
                ->label('Slug'),
            DateTimePicker::make('upload_time')
                ->default(now())
                ->required()
                ->label('Waktu Unggah'),
        ]);
}


public static function table(Table $table): Table
{
    return $table
        ->columns([
            Tables\Columns\TextColumn::make('name')
                ->label('Judul')
                ->sortable()
                ->searchable(),
            Tables\Columns\TextColumn::make('category.name')
                ->label('Kategori'),
            Tables\Columns\TextColumn::make('user.name') // Menampilkan nama author
                ->label('Author')
                ->sortable()
                ->searchable(),
            Tables\Columns\TextColumn::make('content')
                ->label('Content')
                ->limit(50),
            Tables\Columns\ImageColumn::make('thumbnail')
                ->label('Thumbnail')
                ->size(150),
            Tables\Columns\TextColumn::make('upload_time')
                ->label('Waktu Unggah')
                ->dateTime()
                ->sortable(),
            Tables\Columns\TextColumn::make('created_at')
                ->label('Dibuat Pada')
                ->dateTime()
                ->sortable(),
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
            'index' => Pages\ListNews::route('/'),
            'create' => Pages\CreateNews::route('/create'),
            'edit' => Pages\EditNews::route('/{record}/edit'),
        ];
    }
}
