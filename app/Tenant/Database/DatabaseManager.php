<?php

namespace App\Tenant\Database;

use App\User;
use Illuminate\Support\Facades\DB;

class DatabaseManager
{
    public function createdDatabase(User $user) {
        
        return DB::statement("
            CREATE DATABASE {$user->db_chave} CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci
        ");
    }
}

?>