<?php
namespace App\Filament\Resources;

use App\Filament\Resources\ReportResource\Pages;
use App\Models\Report;
use Cheesegrits\FilamentGoogleMaps\Fields\Map;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Http;

class ReportResource extends Resource
{
    protected static ?string $model = Report::class;

    protected static ?string $navigationLabel = 'Reclamações';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Forms\Form $form): Forms\Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('type')
                    ->options([
                        'flood' => 'Áreas Alagadas',
                        'illegal_dump' => 'Descarte Irregular de Lixo',
                    ])
                    ->required(),
                Forms\Components\Textarea::make('description')
                    ->label('Descrição')
                    ->required(),
                Forms\Components\TextInput::make('address')
                    ->label('Endereço')
                    ->required(),
                Forms\Components\TextInput::make('city')
                    ->label('Cidade')
                    ->required(),
                Forms\Components\TextInput::make('postal_code')
                    ->label('CEP')
                    ->required(),
                Forms\Components\Select::make('status')
                    ->options([
                        'pending' => 'Pendente',
                        'approved' => 'Aprovado',
                        'rejected' => 'Recusado',
                    ])
                    ->required()
                    ->default('pending'),

                Map::make('location')
                    ->label('Localização no Mapa')
                    ->defaultLocation(function ($record) {
                        if ($record && $record->latitude && $record->longitude) {
                            return [$record->latitude, $record->longitude];
                        } elseif ($record && $record->address && $record->city && $record->postal_code) {
                            $address = $record->address . ', ' . $record->postal_code . ', ' . $record->city;
                            $response = Http::get('https://maps.googleapis.com/maps/api/geocode/json', [
                                'address' => $address,
                                'key' => env('GOOGLE_MAPS_API_KEY'),
                            ]);
                            $data = $response->json();
                            if ($data['status'] === 'OK') {
                                $location = $data['results'][0]['geometry']['location'];
                                return [$location['lat'], $location['lng']];
                            }
                        }
                        return [-23.55052, -46.633308];
                    })
                    ->defaultZoom(12)
                    ->columnSpan(2)
                    ->height('400px'),

            ]);
    }

    public static function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.email')
                    ->label('Email do Usuário')
                    ->searchable(),
                Tables\Columns\TextColumn::make('type')
                    ->label('Tipo de Denúncia')
                    ->searchable(),
                Tables\Columns\TextColumn::make('postal_code')
                    ->label('CEP')
                    ->searchable(),
                Tables\Columns\SelectColumn::make('status')
                    ->label('Status')
                    ->options([
                        'pending' => 'Pendente',
                        'approved' => 'Aprovado',
                        'rejected' => 'Recusado',
                    ]),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->label('Status')
                    ->options([
                        'pending' => 'Pendente',
                        'approved' => 'Aprovado',
                        'rejected' => 'Recusado',
                    ]),
            ])
            ->actions([
                Tables\Actions\Action::make('approve')
                    ->label('Aprovar')
                    ->action(function (Report $record) {
                        $address = $record->address . ', ' . $record->postal_code . ', ' . $record->city;
                        if ($address) {
                            $response = Http::get('https://maps.googleapis.com/maps/api/geocode/json', [
                                'address' => $address,
                                'key' => env('GOOGLE_MAPS_API_KEY'),
                            ]);
                            $data = $response->json();
                            if ($data['status'] === 'OK') {
                                $location = $data['results'][0]['geometry']['location'];
                                $latitude = $location['lat'];
                                $longitude = $location['lng'];
                                $record->update([
                                    'status' => 'approved',
                                    'latitude' => $latitude,
                                    'longitude' => $longitude,
                                ]);
                            } else {
                                throw new \Exception('Erro ao obter coordenadas: ' . $data['status']);
                            }
                        } else {
                            throw new \Exception('Endereço não disponível para geocodificação');
                        }
                    })
                    ->requiresConfirmation()
                    ->color('success')
                    ->hidden(fn(Report $record) => $record->status === 'approved' || $record->status === 'rejected'),

                Tables\Actions\Action::make('reject')
                    ->label('Recusar')
                    ->action(fn(Report $record) => $record->update(['status' => 'rejected']))
                    ->requiresConfirmation()
                    ->color('danger')
                    ->hidden(fn(Report $record) => $record->status === 'approved' || $record->status === 'rejected'),

                Tables\Actions\Action::make('remove_from_map')
                    ->label('Remover do Mapa')
                    ->action(fn(Report $record) => $record->update(['status' => 'pending', 'latitude' => null, 'longitude' => null]))
                    ->color('danger')
                    ->requiresConfirmation()
                    ->hidden(fn(Report $record) => $record->status !== 'approved'),
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
            'index' => Pages\ListReports::route('/'),
            'create' => Pages\CreateReport::route('/create'),
            'edit' => Pages\EditReport::route('/{record}/'),
        ];
    }
}