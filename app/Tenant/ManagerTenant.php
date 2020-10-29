<?php

namespace App\Tenant;
use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ManagerTenant
{

    public function setConnection(User $user) {

        DB::purge('tenant');

        config()->set('database.connections.tenant.host', 'localhost');
        config()->set('database.connections.tenant.database', $user->db_chave);
        config()->set('database.connections.tenant.username', 'root');
        config()->set('database.connections.tenant.password', '');

        DB::reconnect('tenant');

        Schema::connection('tenant')->getConnection()->reconnect();
    }

}

?>