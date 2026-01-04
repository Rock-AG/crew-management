<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

use function Laravel\Prompts\clear;
use function Laravel\Prompts\confirm;
use function Laravel\Prompts\form;
use function Laravel\Prompts\info;
use function Laravel\Prompts\multiselect;
use function Laravel\Prompts\note;
use function Laravel\Prompts\password;
use function Laravel\Prompts\select;
use function Laravel\Prompts\table;

class AdminUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:admin-users';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'User administration';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $task = select(
            label: __('console.adminUsers.task.label'),
            options: [
                'add' => __('console.adminUsers.task.add'),
                'list' => __('console.adminUsers.task.list'),
                'remove' => __('console.adminUsers.task.remove'),
                'exit' => __('console.adminUsers.task.exit'),
            ],
            default: 'list'
        );

        switch ($task) {
            case 'add':
                clear();
                return $this->taskAdd();
                break;

            case 'list':
                clear();
                return $this->taskList();
                break;

            case 'remove':
                clear();
                return $this->taskRemove();
                break;

            default:
                return;
        }
    }

    /**
     * Execute the 'add' task
     */
    protected function taskAdd()
    {
        $this->getOutput()->title(__('console.adminUsers.add.title'));

        $responses = form()
            ->text(
                name: 'email',
                label: __('console.adminUsers.add.email'),
                placeholder: __('console.adminUsers.add.email'),
                required: true,
                validate: ['email' => 'email|max:255|unique:users,email']
            )
            ->password(
                name: 'password',
                label: __('console.adminUsers.add.password'),
                placeholder: __('console.adminUsers.add.password'),
                required: true,
                validate: ['password' => 'min:8']
            )
            ->add(function ($responses) {
                return password(
                    label: __('console.adminUsers.add.passwordConfirmation'),
                    placeholder: __('console.adminUsers.add.passwordConfirmation'),
                    required: true,
                    validate: function (string $value) use ($responses) {
                        if ($value != $responses['password']) {
                            return __('console.adminUsers.add.passwordConfirmationFailed');
                        }
                        return null;
                    }
                );
            }, name: 'passwordConfirmation')
            ->submit();
            
        $submit = confirm(__('console.adminUsers.add.confirm.label', ['email' => $responses['email']]));
        
        if ($submit) {
            User::create([
                'name' => $responses['email'],
                'email' => $responses['email'],
                'password' => bcrypt($responses['password']),
            ]);
            info(__('console.adminUsers.add.success', ['email' => $responses['email']]));
        } else {
            note(__('console.adminUsers.add.aborted'));
        }

        return $this->handle();
    }

    /**
     * Execute the 'list' task
     */
    protected function taskList()
    {
        $this->getOutput()->title(__('console.adminUsers.list.title'));

        $users = User::all(['email', 'created_at']);
        $usersArray = [];
        foreach ($users as $user) {
            $usersArray[] = [
                $user['email'],
                $user['created_at']->translatedFormat("d. F Y | H:i"),
            ];
        }

        table(
            headers: [__('console.adminUsers.list.email'), __('console.adminUsers.list.created_at')],
            rows: $usersArray
        );

        return $this->handle();
    }

    /**
     * Execute the 'remove' task
     */
    protected function taskRemove()
    {
        $this->getOutput()->title(__('console.adminUsers.remove.title'));

        $usersToRemove = multiselect(
            label: __('console.adminUsers.remove.select'),
            options: User::pluck('email', 'id'),
            scroll: 10
        );
        $count = count($usersToRemove);

        if ($count == 0) {
            info(__('console.adminUsers.remove.noneRemoved'));
            return $this->handle();
        }
        
        $confirm = confirm(trans_choice('console.adminUsers.remove.confirm', count($usersToRemove)));
        if ($confirm) {
            User::destroy($usersToRemove);
            info(trans_choice('console.adminUsers.remove.removed', count($usersToRemove)));
        } else {
            info(__('console.adminUsers.remove.noneRemoved'));
        }

        return $this->handle();
    }
}
