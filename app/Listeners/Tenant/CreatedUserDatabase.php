<?php

namespace App\Listeners\Tenant;

use App\Events\Tenant\UserCreated;
use App\Events\Tenant\DatabaseCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Tenant\Database\DatabaseManager;
use App\User;

class CreatedUserDatabase
{   
    private $database;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(DatabaseManager $database)
    {
        $this->database = $database;
    }

    /**
     * Handle the event.
     *
     * @param  UserCreated  $event
     * @return void
     */
    public function handle(UserCreated $event)
    {
        $user = $event->getUser();

        if (!$this->database->createdDatabase($user)) {
            throw new \Exception('Erro na criação da tabela');
        }

        //run migrations

        event(new DatabaseCreated($user));
    }
}
