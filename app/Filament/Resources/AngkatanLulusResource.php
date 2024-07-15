<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\User;
use Filament\Tables;
use App\Models\Alumni;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\AngkatanLulus;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\AngkatanLulusResource\Pages;
use App\Filament\Resources\AngkatanLulusResource\RelationManagers;

class AngkatanLulusResource extends Resource
{
    protected static ?string $model = AngkatanLulus::class;

    protected static ?string $navigationIcon = 'heroicon-o-clock';

    protected static ?string $navigationGroup = 'Administrator';

    protected static ?string $navigationLabel = 'Tahun Lulus';

    protected static ?string $slug = 'tahun-lulus';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('tahun')
                    ->numeric(),
                Forms\Components\TextInput::make('jumlah_angkatan')
                    ->numeric(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('tahun')
                    ->sortable(),
                Tables\Columns\TextColumn::make('jumlah_angkatan')
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
            ->actions([
                Tables\Actions\Action::make('alumni')
                    ->label('Alumnikan')
                    ->icon('heroicon-o-academic-cap')
                    ->action(function (AngkatanLulus $angkatanLulus) {
                        $angkatanLulusId = $angkatanLulus->id;

                        $users = User::where('angkatan_lulus_id', $angkatanLulusId)->get();

                        if ($users) {
                            foreach ($users as $user) {
                                // Create a new alumni record
                                Alumni::create([
                                    'angkatan_lulus_id' => $angkatanLulusId,
                                    'name' => $user->name,
                                    'email' => $user->email,
                                    'username' => $user->username,
                                    'email_verified_at' => $user->email_verified_at,
                                    'password' => $user->password,
                                    'is_can_choose' => $user->is_can_choose,
                                    'is_choosed' => $user->is_choosed,
                                    'nilai' => $user->nilai,
                                    'kelas' => $user->kelas,
                                    'program' => $user->program,
                                    'ranking' => $user->ranking,
                                    'eligible' => $user->eligible,
                                    'kampus_pilihan_id' => $user->pilihans->kampus_id ?? null,
                                    'jurusan_pilihan_id' => $user->pilihans->jurusan_id ?? null,
                                ]);
    
                                // Delete the user record
                                $user->delete();
                            }
    
                            $angkatanLulusCount = AngkatanLulus::find($angkatanLulusId);
                            if ($angkatanLulusCount->jumlah_angkatan) {
                                $angkatanLulusCount->jumlah_angkatan = $angkatanLulusCount->jumlah_angkatan + $users->count();
                                $angkatanLulusCount->save();
                            } else {
                                $angkatanLulusCount->jumlah_angkatan = $users->count();
                                $angkatanLulusCount->save();
                            }
                        }
                    }),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageAngkatanLuluses::route('/'),
        ];
    }
}
