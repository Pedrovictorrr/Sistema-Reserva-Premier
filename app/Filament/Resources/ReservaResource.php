<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ReservaResource\Pages;
use App\Filament\Resources\ReservaResource\RelationManagers;
use App\Models\Reserva;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ReservaResource extends Resource
{
    protected static ?string $model = Reserva::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';



    public static function form(Form $form): Form
    {
        function horasDisponiveis($data)
        {
            // Obtém a lista de todas as reservas para a data fornecida
            if ($data == null) {
                return [];
            }
            $reservas = Reserva::whereDate('data', $data)->get();

            // Define o horário de funcionamento
            $horarioInicio = Carbon::createFromFormat('H:i:s', '08:00:00');
            $horarioFim = Carbon::createFromFormat('H:i:s', '22:00:00');

            // Inicializa o array de horas ocupadas
            $horasOcupadas = [];

            // Itera sobre as reservas e marca as horas ocupadas
            foreach ($reservas as $reserva) {
                $reservaInicio = Carbon::createFromFormat('H:i:s', $reserva->hora_inicio);
                $reservaFim = Carbon::createFromFormat('H:i:s', $reserva->hora_fim);

                // Adiciona as horas ocupadas ao array
                while ($reservaInicio <= $reservaFim) {
                    $horasOcupadas[$reservaInicio->format('H:i:s')] = true;
                    $reservaInicio->addHour(); // Adiciona uma hora
                }
            }

            // Inicializa o array de horas disponíveis
            $horasDisponiveis = [];

            // Encontra os intervalos de horas disponíveis entre as reservas
            $horaAtual = $horarioInicio->copy();
            while ($horaAtual <= $horarioFim) {
                $horaAtualFormatada = $horaAtual->format('H:i:s');
                if (!isset($horasOcupadas[$horaAtualFormatada])) {
                    $horasDisponiveis[$horaAtualFormatada] = $horaAtualFormatada;
                }
                $horaAtual->addHour(); // Adiciona uma hora
            }

            return $horasDisponiveis;
        }


      // Substitua pelo caminho correto da sua Model Reserva

      function horasDisponiveisDepois($data, $horaSelecionada)
      {
          $horasDisponiveis = horasDisponiveis($data);
          
          // Verifica se a hora selecionada está no array de horas disponíveis
          if (isset($horasDisponiveis[$horaSelecionada])) {
              // Obtém a chave da hora selecionada no array de horas disponíveis
              $indiceHoraSelecionada = array_search($horaSelecionada, array_keys($horasDisponiveis));
              
              // Remove as horas disponíveis antes da hora selecionada (incluindo a hora selecionada)
              $horasDisponiveis = array_slice($horasDisponiveis, $indiceHoraSelecionada + 1);
              
              // Encontra o início da próxima reserva (primeira hora ocupada após a hora selecionada)
              $proximoInicioReserva = Reserva::where('data', $data)
                  ->where('hora_inicio', '>', $horaSelecionada)
                  ->orderBy('hora_inicio', 'asc')
                  ->first();
              
              // Se existe uma próxima reserva, gera as horas disponíveis entre a hora selecionada e o início da próxima reserva em intervalos de 1 hora
              if ($proximoInicioReserva) {
                  $horasDisponiveisEntre = [];
                  $horaAtual = Carbon::createFromFormat('H:i:s', $horaSelecionada);
                  while ($horaAtual->format('H:i:s') != $proximoInicioReserva->hora_inicio) {
                      $horaAtual->addHour(); // Adiciona 1 hora
                      $horasDisponiveisEntre[$horaAtual->format('H:i:s')] = $horaAtual->format('H:i:s');
                  }
                  return $horasDisponiveisEntre;
              } else {
                  // Não há próxima reserva, então retorna as horas disponíveis após a hora selecionada em intervalos de 1 hora até 22:00
                  $horasDisponiveisEntre = [];
                  $horaAtual = Carbon::createFromFormat('H:i:s', $horaSelecionada);
                  while ($horaAtual->format('H:i:s') < '22:00:00') {
                      $horaAtual->addHour(); // Adiciona 1 hora
                      $horasDisponiveisEntre[$horaAtual->format('H:i:s')] = $horaAtual->format('H:i:s');
                  }
                  return $horasDisponiveisEntre;
              }
          } else {
              // A hora selecionada não é válida
              return [];
          }
      }
      
      
      
      
      
        
        
        
        
        

        return $form
            ->schema([
                Section::make('Dados da reserva')->schema([

                    Forms\Components\Select::make('sala_id')
                        ->required()
                        ->relationship(name: 'sala', titleAttribute: 'nome')
                        ->preload()
                        ->searchable(),
                    Forms\Components\DatePicker::make('data')
                        ->native(false)
                        ->required()
                        ->minDate(now()->format('Y-m-d')),
                    Forms\Components\Select::make('hora_inicio')
                        ->native(false)
                        ->required()
                        ->options(fn (Get $get): array => horasDisponiveis($get('data'))),
                    Forms\Components\Select::make('hora_fim')
                        ->native(false)
                        ->required()
                        ->options(fn (Get $get): array => horasDisponiveisDepois($get('data'), $get('hora_inicio'))),
                ])->columns(2),
                Section::make('Convidados')->schema([
                    Repeater::make('convidados')->label('')
                        ->relationship()
                        ->schema(
                            [
                                TextInput::make('nome')->placeholder('Nome Convidado'),
                                Hidden::make('user_id')->default(Auth()->user()->id)
                            ]

                        ),

                ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('Responsavel.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('sala.nome')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('hora_inicio')
                    ->Time()
                    ->sortable(),
                Tables\Columns\TextColumn::make('hora_fim')
                    ->Time()
                    ->sortable(),
                Tables\Columns\TextColumn::make('data')
                    ->dateTime('d/m/Y')
                    ->sortable(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
            'index' => Pages\ListReservas::route('/'),
            'create' => Pages\CreateReserva::route('/create'),
            'edit' => Pages\EditReserva::route('/{record}/edit'),
        ];
    }
}
