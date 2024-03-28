<?php

namespace App\Filament\Admin\Resources;

use App\Enums\Branch;
use App\Enums\UserPosition;
use App\Filament\Admin\Resources\UserResource\Pages;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Support\Enums\Alignment;
use Illuminate\Support\Facades\Hash;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationLabel = 'สมาชิก';

    protected static ?string $pluralModelLabel = 'สมาชิก';

    protected static ?string $navigationIcon = 'heroicon-m-user-group';

    protected static ?int $navigationSort = 4;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Group::make()
                ->schema([
                    Forms\Components\Section::make()
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label(('ชื่อ'))
                            ->required(),
                        Forms\Components\TextInput::make('phone')
                            ->label('เบอร์โทรศัพท์')
                            ->hint('ไม่ต้องใส่ขีดกลาง (-)')
                            ->regex('/^0\d{8,9}$/')
                            ->validationAttribute('เบอร์โทรศัพท์')
                            ->required(),
                        Forms\Components\TextInput::make('email')
                            ->label(('อีเมล'))
                            ->regex('/^[\w\.-]+@[\w\.-]+\.\w+$/')
                            ->unique(ignorable: fn ($record) => $record)
                            ->required(),
                        Forms\Components\Select::make('position')
                            ->label(('สถานะ'))
                            ->lazy()
                            ->options(UserPosition::class)
                            ->required(),
                        Forms\Components\Select::make('branch')
                            ->label('สาขา')
                            ->required()
                            ->options(Branch::class)
                            ->hidden(function(Forms\Get $get){
                                if ($get('position') != 'student' || $get('position') != 'teacher') {
                                    return true;
                                }
                            }),
                        Forms\Components\TextInput::make('password')
                            ->label('รหัสผ่าน')
                            ->helperText('รหัสผ่าน ต้องมีความยาวมากกว่า 8 และไม่เกิน 30 ตัวอักษร')
                            ->password()
                            ->revealable()
                            ->minLength(8)
                            ->maxLength(30)
                            ->afterStateHydrated(function (Forms\Components\TextInput $component, $state) {
                                $component->state('');
                            })
                            ->dehydrateStateUsing(fn ($state) => Hash::make($state))
                            ->dehydrated(fn ($state) => filled($state))
                            ->required(fn (string $context): bool => $context === 'create'),
                        Forms\Components\Select::make('user_role')
                            ->label('ตําแหน่งการใช้งานระบบ')
                            ->required()
                            ->options([
                                'admin' => 'ผู้ดูแลระบบ',
                                'customer' => 'ผู้ใช้งาน',
                            ])
                            ->default('customer'),
                    ])->columns(2)
                ])->columnSpan(['lg' => fn (?User $record) => $record === null ? 3 : 2]),
                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make()
                            ->schema([
                                Forms\Components\Placeholder::make('created_at')
                                    ->label('สร้างเมื่อ')
                                    ->content(fn (User $record): ?string => $record->created_at?->format('d/m/Y H:i:s').' ('.$record->created_at?->diffForHumans().')'),

                                Forms\Components\Placeholder::make('updated_at')
                                    ->label('แก้ไขล่าสุด')
                                    ->content(fn (User $record): ?string => $record->updated_at?->format('d/m/Y H:i:s').' ('.$record->updated_at?->diffForHumans().')'),
                            ])
                            ->columnSpan(['lg' => 1])
                            ->hidden(fn (?User $record) => $record === null),
                        ]),
                ])
                ->columns([
                    'sm' => null,
                    'lg' => 3,
                ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label(('ชื่อ'))
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('phone')
                    ->label('เบอร์โทรศัพท์')
                    ->placeholder('-')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->label(('อีเมล'))
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('branch')
                    ->label('สาขา')
                    ->placeholder('-')
                    ->sortable()
                    ->badge()
                    ->searchable(),
                Tables\Columns\TextColumn::make('position')
                    ->label('สถานะ')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('user_role')
                    ->label('ตําแหน่งการใช้งานระบบ')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->alignment(Alignment::Center)
                        ->label('เป็นสมาชิกเมื่อ')
                        ->dateTime('d/m/Y H:i:s')
                        ->sortable()
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->label('แก้ไข'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->label('ลบ'),
                    Tables\Actions\ExportBulkAction::make('export')

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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
