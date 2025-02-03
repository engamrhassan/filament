<?php

namespace App\Filament\Resources\CategoryResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Columns\CheckboxColumn;
use Filament\Tables\Columns\ColorColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PostsRelationManager extends RelationManager
{
    protected static string $relationship = 'posts';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Create a post')
                    ->description('Create post as a description')
//                    ->aside()
//                    ->collapsible()
                    ->schema([

                        TextInput::make('title')->required()
                            ->rules(['max:25','min:4',]), // 'in:pending,in progress,completed'

                        TextInput::make('slug')->required()->unique(ignoreRecord: true),

                        Select::make('category_id')
                            ->label('Category')
//                        ->searchable()
                            ->relationship('category', 'name'), // better than use option
//                        ->options(Category::all()->pluck('name', 'id')->toArray()),

                        ColorPicker::make('color'),

                        MarkdownEditor::make('content')->columnSpanFull(),

                    ])->columnSpan(2)->columns(2),
                Group::make()->schema([
                    Section::make('Image')
                        ->collapsible()
                        ->schema([
                            FileUpload::make('thumbnail')->disk('public')->directory('thumbnails'),
                        ]) ,
                    Section::make('Meta')->schema([
                        TagsInput::make('tags')->required(),
                        Checkbox::make('is_published'),
                    ])
                ])->columnSpan(1),


            ])->columns(3);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('title')
            ->columns([
                TextColumn::make('id'), // hidden by default
                ImageColumn::make('thumbnail'),

                TextColumn::make('title')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('slug'),

                TextColumn::make('tags'),

            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
//                Tables\Actions\EditAction::make(),
//                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
//                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
