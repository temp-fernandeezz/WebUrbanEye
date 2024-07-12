<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ReportResource\Pages;
use App\Filament\Resources\ReportResource\RelationManagers;
use App\Models\Report;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Http;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ReportResource extends Resource
{
    protected static ?string $model = Report::class;

    protected static ?string $navigationLabel = 'Reclamações';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
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
                    ->required(),
                Forms\Components\TextInput::make('address')
                    ->required(),
                Forms\Components\Select::make('status')
                    ->options([
                        'pending' => 'Pendente',
                        'approved' => 'Aprovado',
                        'rejected' => 'Recusado',
                    ])
                    ->required()
                    ->default('pending'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('type')
                    ->label('Tipo de Denúncia')
                    ->searchable(),
                Tables\Columns\TextColumn::make('description')
                    ->label('Descrição')
                    ->searchable(),
                Tables\Columns\TextColumn::make('address')
                    ->label('Localização')
                    ->searchable(),
                Tables\Columns\SelectColumn::make('status')
                    ->label('Status')
                    ->options([
                        'pending' => 'Pendente',
                        'approved' => 'Aprovado',
                        'rejected' => 'Recusado',
                    ]),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\Action::make('approve')
                    ->label('Aprovar')
                    ->action(function (Report $record) {
                        // Obter o endereço a partir do CEP
                        $address = $record->address;
            
                        if ($address) {
                            // Obter a latitude e longitude do endereço
                            $response = Http::get('https://maps.googleapis.com/maps/api/geocode/json', [
                                'address' => $address,
                                'key' => env('GOOGLE_MAPS_API_KEY'), // Adicione sua chave da API do Google Maps aqui
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
                    ->color('success'),


                Tables\Actions\Action::make('reject')
                    ->label('Recusar')
                    ->action(fn(Report $record) => $record->update(['status' => 'rejected']))
                    ->requiresConfirmation()
                    ->color('danger'),
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
