<?php

namespace App\Filament\Resources;

use App\Enums\BookingStatus;
use App\Enums\MemberTypeEnum;
use App\Enums\RoomStatusEnum;
use App\Filament\Exports\BookingExporter;
use App\Filament\Resources\BookingResource\Pages;
use App\Filament\Resources\BookingResource\RelationManagers;
use App\Models\Booking;
use App\Models\Member;
use App\Models\Room;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\ExportAction;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use pxlrbt\FilamentExcel\Actions\Tables\ExportAction as TablesExportAction;

use function Laravel\Prompts\select;
use function Pest\Laravel\options;

class BookingResource extends Resource
{
    protected static ?string $model = Booking::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Records Management';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
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
                    ->options(fn (): Collection => Room::query()
                        ->where('status', RoomStatusEnum::Open)
                        ->pluck('number', 'id'))
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

    public static function table(Table $table): Table
    {
        return $table
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
                SelectFilter::make('room_id')
                    ->relationship('room', 'number')
                    ->searchable()
                    ->label('Room')
                    ->native(false),
                SelectFilter::make('status')
                    ->options(BookingStatus::class)
                    ->searchable()
                    ->native(false)
            ], layout: FiltersLayout::AboveContent)
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()->after(function($records) {
                         $ids = $records->pluck('room_id')->toArray();
                         Room::whereIn('id', $ids)->update(['status' => RoomStatusEnum::Open]);
                    }),
                ]),
            ])->headerActions([
                TablesExportAction::make()
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
            'index' => Pages\ListBookings::route('/'),
            'create' => Pages\CreateBooking::route('/create'),
            'view' => Pages\ViewBooking::route('/{record}'),
            'edit' => Pages\EditBooking::route('/{record}/edit'),
        ];
    }
}
