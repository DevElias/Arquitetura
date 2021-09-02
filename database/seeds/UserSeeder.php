<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $users = [
            ['Administrador', 'adm@alfaiatariadesistemas.com', '12345','09095034677','01071990','0800591203','912345678','01140060','Av. Nicolas Boer, 399','1399','Apartamento','Agua Branca','São Paulo','SP','0','1',0,'2020-05-08 22:25:44',0,NULL]
        ];
        
        for ($i = 0; $i < count($users); $i++) {
            DB::table('usuario')->insert([
                'nome' => $users[$i][0],
                'email' => $users[$i][1],
                'senha' => $users[$i][2],
                'cpf' => $users[$i][3],
                'data_nascimento' => $users[$i][4],
                'telefone' => $users[$i][5],
                'whatsapp' => $users[$i][5],
                'cep' => $users[$i][6],
                'endereco' => $users[$i][7],
                'numero' => $users[$i][8],
                'complemento' => $users[$i][9],
                'bairro' => $users[$i][10],
                'cidade' => $users[$i][11],
                'estado' => $users[$i][12],
                'tipo_usuario' => $users[$i][13],
                'status' => $users[$i][14],
                'usuario_inclusao' => $users[$i][15],
                'data_inclusao' => now(),
                'usuario_alteracao' => $users[$i][17],
                'data_alteracao' => now()
            ]);
        }
    }
}
