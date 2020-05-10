<?php

use Illuminate\Database\Seeder;

class AddACLSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        // Roles
        $adminACL = \App\Role::firstOrCreate(['name'=>'Admin'],[
          'description'=>'Função de Administrador'
        ]);
        $gerenteACL = \App\Role::firstOrCreate(['name'=>'Gerente'],[
          'description'=>'Função de Gerente'
        ]);

        // User com Role
        $userAdmin = \App\User::find(1);
        $userGerente = \App\User::find(2);

        $userAdmin->roles()->attach($adminACL);
        $userGerente->roles()->attach($gerenteACL);

        // Permissions

        $listUser = \App\Permission::firstOrCreate(['name'=>'list-user'],[
          'description'=>'Listar registros'
        ]);
        $createUser = \App\Permission::firstOrCreate(['name'=>'create-user'],[
          'description'=>'Criar registro'
        ]);
        $editUser = \App\Permission::firstOrCreate(['name'=>'edit-user'],[
          'description'=>'Editar registro'
        ]);
        $showUser = \App\Permission::firstOrCreate(['name'=>'show-user'],[
          'description'=>'Visualizar registro'
        ]);

        $deleteUser = \App\Permission::firstOrCreate(['name'=>'delete-user'],[
          'description'=>'Deletar registro'
        ]);

        $acessoACL = \App\Permission::firstOrCreate(['name'=>'acl'],[
          'description'=>'Acesso ao ACL'
        ]);
        
        $acessoBetting = \App\Permission::firstOrCreate(['name'=>'manage-bets'],[
          'description'=>'Acesso ao ACL'
        ]);

        // Role com Permission

        $gerenteACL->permissions()->attach($listUser);
        $gerenteACL->permissions()->attach($createUser);


        echo "Registros de ACL criados! \n";
    }
}
