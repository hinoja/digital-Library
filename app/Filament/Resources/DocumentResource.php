<?php

namespace App\Filament\Resources;

use App\Enums\Type;
use Filament\Forms;
use App\Enums\Level;
use Filament\Tables;
use App\Models\Option;
use App\Models\Document;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Filament\Resources\Resource;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\DocumentResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\DocumentResource\RelationManagers;
use Filament\Facades\Filament;

class DocumentResource extends Resource
{
    protected static ?string $model = Document::class;

    protected static ?string $navigationIcon = 'heroicon-o-document';

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
    public static function form(Form $form): Form
    {
        return $form

            ->schema([
                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make('informations')->schema([
                            Forms\Components\TextInput::make('title')->label('Intitulé')->required()->live(onBlur: true)->unique()
                            ->afterStateUpdated(function (string $operation,$state,Forms\Set $set){
                                if($operation !== 'create'){
                                    return ;
                                }
                                $set('slug',Str::slug($state));
                            }),
                            Forms\Components\TextInput::make('slug')->disabled()->dehydrated()->required()->unique(),
                            Forms\Components\MarkdownEditor::make('description')->required(),
                            Forms\Components\Toggle::make('is_visible')->label('est visible'),
                            // Forms\Components\TextInput::make('password'),
                            // Forms\Components\Toggle::make('is_active'),
                            // Forms\Components\DatePicker::make('name'),
                        ]),
                    ]),

                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make('details')
                            ->schema([
                                Forms\Components\Select::make('type')->options([
                                    'Projet de Memoire' => Type::PROJET->value,
                                    'Rapport de Stage' => Type::STAGE->value,
                                ]),
                                Forms\Components\Select::make('level')->label('Niveau')->options([
                                    '1' => Level::NIVEAU1->value,
                                    '2' => Level::NIVEAU2->value,
                                    '3' => Level::NIVEAU3->value,
                                    '4' => Level::NIVEAU4->value,
                                    '5' => Level::NIVEAU5->value,
                                    '>5' => Level::NIVEAUPlus->value,
                                ]),
                                Forms\Components\Select::make('option_id')->label('Filière')->options(Option::query()->pluck('name', 'id')),
                                Forms\Components\DatePicker::make('published_at')->label('publié à'),
                                Forms\Components\Select::make('keyword')->label('mot(s)-clés')->relationship('keywords', 'name')->multiple()->required(),
                                Forms\Components\Select::make('category')->label('Catégory(es)')->relationship('categories', 'name')->multiple()->required(),
                                Forms\Components\TextInput::make('github_link')->label('lien github'),
                                Forms\Components\TextInput::make('user_id')->label('user_id')->required()->default(Filament::auth()->id())->readOnly()->disabled(),
                            ])
                    ]),
                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make('auteurs')
                            ->schema([
                                Forms\Components\TextInput::make('author')->label('Rédigé par')->required()->live(onBlur: true),
                                Forms\Components\TextInput::make('supervisor')->label('Encadré par')->required()->live(onBlur: true),
                            ])
                    ]),
                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make('file')
                            ->schema([
                                Forms\Components\FileUpload::make('file')->directory('documents') ->openable()->label('Fichier')->directory('form-attachments')->downloadable()->acceptedFileTypes(['application/pdf'])->openable()->maxSize(10240),
                            ])->collapsible()
                    ]),

            ]);
    }


    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title'), 
                TextColumn::make('level'),
                TextColumn::make('type'), 
                TextColumn::make('extension'), 
                IconColumn::make('is_visible')->boolean(),
                TextColumn::make('created_at')->since(),
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
            'index' => Pages\ListDocuments::route('/'),
            'create' => Pages\CreateDocument::route('/create'),
            'edit' => Pages\EditDocument::route('/{record}/edit'),
        ];
    }
}
