<?php

namespace App\Console\Commands\Tenant;

use Illuminate\Console\Command;
use App\Tenant\ManagerTenant;
use Illuminate\Support\Facades\Artisan;
use App\User;

class TenantMigrations extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tenants:migrations {id?} {--refresh}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run migrations to tenants';

    private $tenant;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(ManagerTenant $tenant)
    {
        parent::__construct();

        $this->tenant = $tenant;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {   

        if ($id = $this->argument('id')){
            $user = User::find($id);

            if($user) {
                $this->execCommand($user);
            }

            return;
        }

        $users = User::all();
        
        foreach($users as $user) {

            $this->execCommand($user);
        }
    }

    public function execCommand(User $user) {

        $command = $this->option('refresh') ? 'migrate:refresh' : 'migrate';

        if($user->db_chave != 'restaurante') {
            $this->tenant->setConnection($user);

            $this->info("Connection user db_chave {$user->db_chave}");

            Artisan::call($command, [
                '--force' => true,
                '--path' => '/database/migrations/tenant',
            ]);

            $this->info("End connection user db_chave {$user->db_chave}");
            $this->info('----------------------------------------------');
        }
    }
}