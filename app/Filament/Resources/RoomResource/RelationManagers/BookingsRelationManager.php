<?php

namespace App\Filament\Resources\RoomResource\RelationManagers;

use App\Enums\BookingStatus;
use App\Enums\MemberTypeEnum;
use App\Enums\RoomStatusEnum;
use App\Models\Member;
use App\Models\Room;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Collection;

class BookingsRelationManager extends RelationManager
{
    protected static string $relationship = 'bookings';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('member_id')
                    ->relationship('member', 'name')
                    ->native(false)
                    ->live()
                    ->searchable()
                    ->preload()
                    ->required(),
                Forms\Components\Select::make('room_id')
                    ->live()
                    ->options(function (Get $get): Collection {
                        // if ($get('member_id')) {
                        //     # code...
                        //     dd(Member::find($get('member_id'))->type);
                        //     if (Member::find($get('member_id'))->type == MemberTypeEnum::Permanent->value) {
                        //         # code...
                        //         return Room::whereRelation('member', 'id', $get('member_id'))
                        //         ->where('status', RoomStatusEnum::Open)
                        //         ->pluck('number', 'id');
                        //     }else{
                        //         return Room::where('status', RoomStatusEnum::Open)
                        //         ->pluck('number', 'id');
                        //     }
                        // }

                        return Room::where('status', RoomStatusEnum::Open)
                        ->pluck('number', 'id');

                    })
                    ->searchable()
                    ->native(false)
                    ->required(),
                Forms\Components\DateTimePicker::make('from_date')
                    ->native(false)
                    ->required(),
                Forms\Components\DateTimePicker::make('to_date')
                    ->native(false),
                Forms\Components\Select::make('status')
                    ->options(BookingStatus::class)
                    ->required()
                    ->native(false),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('id')
            ->columns([
                Tables\Columns\TextColumn::make('member.name')
                ->numeric()
                ->sortable(),
            Tables\Columns\TextColumn::make('room.number')
                ->sortable(),
            Tables\Columns\TextColumn::make('from_date')
                ->dateTime()
                ->toggleable(isToggledHiddenByDefault: true)
                ->sortable(),
            Tables\Columns\TextColumn::make('to_date')
            ->toggleable(isToggledHiddenByDefault: true)
                ->dateTime()
                ->sortable(),
            Tables\Columns\TextColumn::make('status')
                ->badge()
                ->searchable(),
            Tables\Columns\TextColumn::make('period_onsite')
                ->numeric()
                ->sortable(),
            Tables\Columns\TextColumn::make('created_at')
                ->dateTime()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
            Tables\Columns\TextColumn::make('updated_at')
                ->dateTime()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
