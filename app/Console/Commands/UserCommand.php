<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Hash;

class UserCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'users:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $input['name'] = $this->ask('Your name?');
        $input['email'] = $this->ask('Your email?');
        $input['image'] = $this->ask('Your image name?');
        $input['role'] = 'user';
        $input['password'] = $this->secret('What is the password?');
        $input['password'] = Hash::make($input['password']);

        User::create($input);

        $this->info('User Create Successfully!');
    }
}
