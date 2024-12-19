<?php

namespace App\Actions;

/**
 * @method static \Lorisleiva\Actions\Decorators\JobDecorator|\Lorisleiva\Actions\Decorators\UniqueJobDecorator makeJob(\App\DTOs\Todoist\Task $task)
 * @method static \Lorisleiva\Actions\Decorators\UniqueJobDecorator makeUniqueJob(\App\DTOs\Todoist\Task $task)
 * @method static \Illuminate\Foundation\Bus\PendingDispatch dispatch(\App\DTOs\Todoist\Task $task)
 * @method static \Illuminate\Foundation\Bus\PendingDispatch|\Illuminate\Support\Fluent dispatchIf(bool $boolean, \App\DTOs\Todoist\Task $task)
 * @method static \Illuminate\Foundation\Bus\PendingDispatch|\Illuminate\Support\Fluent dispatchUnless(bool $boolean, \App\DTOs\Todoist\Task $task)
 * @method static dispatchSync(\App\DTOs\Todoist\Task $task)
 * @method static dispatchNow(\App\DTOs\Todoist\Task $task)
 * @method static dispatchAfterResponse(\App\DTOs\Todoist\Task $task)
 * @method static void run(\App\DTOs\Todoist\Task $task)
 */
class AddTodoistTaskToNotion
{
}
/**
 * @method static mixed run(string $name, string $email, ?string $password = null, ?string $googleId = null, ?string $googleToken = null, ?string $googleRefreshToken = null)
 */
class CreateNewUser
{
}
/**
 * @method static \Lorisleiva\Actions\Decorators\JobDecorator|\Lorisleiva\Actions\Decorators\UniqueJobDecorator makeJob(\App\DTOs\Todoist\Task $task)
 * @method static \Lorisleiva\Actions\Decorators\UniqueJobDecorator makeUniqueJob(\App\DTOs\Todoist\Task $task)
 * @method static \Illuminate\Foundation\Bus\PendingDispatch dispatch(\App\DTOs\Todoist\Task $task)
 * @method static \Illuminate\Foundation\Bus\PendingDispatch|\Illuminate\Support\Fluent dispatchIf(bool $boolean, \App\DTOs\Todoist\Task $task)
 * @method static \Illuminate\Foundation\Bus\PendingDispatch|\Illuminate\Support\Fluent dispatchUnless(bool $boolean, \App\DTOs\Todoist\Task $task)
 * @method static dispatchSync(\App\DTOs\Todoist\Task $task)
 * @method static dispatchNow(\App\DTOs\Todoist\Task $task)
 * @method static dispatchAfterResponse(\App\DTOs\Todoist\Task $task)
 * @method static void run(\App\DTOs\Todoist\Task $task)
 */
class DeleteTaskFromTodoist
{
}
namespace Lorisleiva\Actions\Concerns;

/**
 * @method void asController()
 */
trait AsController
{
}
/**
 * @method void asListener()
 */
trait AsListener
{
}
/**
 * @method void asJob()
 */
trait AsJob
{
}
/**
 * @method void asCommand(\Illuminate\Console\Command $command)
 */
trait AsCommand
{
}