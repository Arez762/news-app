<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\News;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Facades\Filament;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Filters\TrashedFilter;
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
                RichEditor::make('content') // Menggunakan RichEditor agar mendukung teks kaya dan gambar
                    ->required()
                    ->label('Konten')
                    ->columnSpan('full'), // Membuat inputan lebih lebar
                FileUpload::make('thumbnail')
                    ->image()
                    ->required()
                    ->label('Thumbnail'),
                FileUpload::make('gallery') // Inputan untuk mengunggah beberapa gambar
                    ->image()
                    ->multiple() // Memungkinkan unggahan banyak gambar
                    ->label('Galeri Gambar')
                    ->directory('galleries') // Direktori untuk menyimpan gambar di dalam storage
                    ->minFiles(1) // Jumlah minimum file yang diunggah
                    ->maxFiles(6), // Jumlah maksimum file yang dapat diunggah
                Select::make('category_id')
                    ->relationship('category', 'name') // Menampilkan nama kategori
                    ->required()
                    ->label('Kategori'),
                Select::make('user_id') // Menggunakan kolom 'user_id' untuk menyimpan ID pengguna yang login
                    ->relationship('user', 'name') // Menggunakan relasi 'user' untuk mengambil 'name' dari model User
                    ->default(Filament::auth()->user()->id) // Mengisi otomatis dengan ID pengguna yang login
                    ->disabled() // Agar nilai ini tidak dapat diubah oleh pengguna
                    ->required() // Memastikan bahwa field ini wajib diisi
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
                    ->searchable()
                    ->limit(20),
                Tables\Columns\TextColumn::make('category.name')
                    ->label('Kategori')
                    ->searchable(),
                Tables\Columns\TextColumn::make('user.name') // Menampilkan nama author
                    ->label('Author')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('content')
                    ->label('Content')
                    ->searchable()
                    ->limit(50)
                    ->html()
                    ->formatStateUsing(fn ($state) => strip_tags($state)),
                Tables\Columns\ImageColumn::make('thumbnail')
                    ->label('Thumbnail')
                    ->size(150),
                Tables\Columns\TextColumn::make('upload_time')
                    ->label('Waktu Unggah')
                    ->dateTime()
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat Pada')
                    ->dateTime()
                    ->sortable()
                    ->searchable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                TrashedFilter::make(), // Menambahkan filter untuk melihat data yang dihapus
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\RestoreAction::make()
                    ->visible(fn($record) => $record->trashed()), // Pastikan hanya tampil untuk data yang dihapus
                Tables\Actions\ForceDeleteAction::make()
                    ->visible(fn($record) => $record->trashed()), // Pastikan hanya tampil untuk data yang dihapus
            ])
            ->bulkActions([
                Tables\Actions\RestoreBulkAction::make()
                    ->visible(fn($records) => $records && $records->isNotEmpty() && $records->contains(fn($record) => $record->trashed())), // Cek jika records tidak kosong
                Tables\Actions\ForceDeleteBulkAction::make()
                    ->visible(fn($records) => $records && $records->isNotEmpty() && $records->contains(fn($record) => $record->trashed())), // Cek jika records tidak kosong
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
