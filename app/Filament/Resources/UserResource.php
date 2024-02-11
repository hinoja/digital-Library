<?php

namespace App\Filament\Resources;

use App\Enums\Role;
use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    protected static ?string $navigationLabel = 'Utilisateurs';
    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function canViewAny(): bool
    {
        return auth()->user()->role == 'administrator';
    }
    public static function form(Form $form): Form
    {
        return $form

            ->schema([
                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make('informations')->schema([
                            Forms\Components\TextInput::make('name')->required()->live(onBlur: true),
                            Forms\Components\TextInput::make('email')->required()->email()->label('email address')->live(onBlur: true)->unique(User::class, 'email'),
                            Forms\Components\TextInput::make('password'),

                            Forms\Components\Toggle::make('is_active'),
                            // Forms\Components\MarkdownEditor::make('description'),
                            // Forms\Components\DatePicker::make('name'),
                        ]),
                    ]),
                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make('details')
                            ->schema([
                                Forms\Components\Select::make('role')->options([
                                    'ADMIN' => Role::ADMIN->value,
                                    'STUDENT' => Role::STUDENT->value,
                                    'TEACHER' => Role::TEACHER->value,
                                ]),
                                Forms\Components\DatePicker::make('birthDate'),
                                Forms\Components\TextInput::make('phone_number')->maxValue(14),
                            ])
                    ]),
                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make('Image')
                            ->schema([
                                Forms\Components\FileUpload::make('avatar')
                                ->avatar()->directory('avatars')->preserveFilenames()->image()->imageEditor(),
                            ])->collapsible()
                    ]),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('avatar'),
                TextColumn::make('name'),
                TextColumn::make('email'),
                TextColumn::make('role'),
                TextColumn::make('phone_number'),
                TextColumn::make('birth_date'),
                IconColumn::make('is_active')->boolean(),
            ])
            ->filters([
                TernaryFilter::make('is_active')->label('Actif')->boolean()->trueLabel('Seulement ceux dont le compte est activé ')->falseLabel('Seulement ceux dont le compte a été bloqué ')->native('false')
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
    // public function getFilamentAvatarUrl(): ?string
    // {
    //     // return $this->photo;
    // }
    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
