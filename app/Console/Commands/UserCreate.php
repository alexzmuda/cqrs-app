<?php

namespace App\Console\Commands;

use App\Modules\User\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;

class UserCreate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create-user {email} {password}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create new user. ex: create-user user@email.com password';

    private $example = 'ex: update-user user@email.com password';

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
     * @return mixed
     */
    public function handle()
    {
        $email = $this->argument('email');
        if (empty($email)) {
            $this->error('email - email parameter is required.' . $this->example);

            return;
        }
        $password = $this->argument('password');
        if (empty($password)) {
            $this->error('password - password parameter is required.' . $this->example);

            return;
        }

        $user = User::whereEmail($email)->first();
        if (null !== $user) {
            $this->error("User with email: {$email} already exists");

            return;
        }


        $user = new User();
        $user->email = $email;
        //$user->email_verified_at = Carbon::now('UTC');
        $user->password = \Hash::make($password);
        $user->created_at = Carbon::now('UTC');
        $user->updated_at = Carbon::now('UTC');
        $user->save();

        $this->info("User {$email} created with password: {$password}");


    }
}
