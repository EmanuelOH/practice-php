<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

use App\Events\UserCreated;
use App\Events\UserUpdated;
use App\Events\UserDeleted;
use App\Events\UserRestore;
use App\Service\DiscordWebhookService;

class SendDiscordNotification
{
    protected $discordWeebhook;

    // Colores predefinidos para cada tipo de acción
    private const COLOR_CREATED = 0x36ff00;
    private const COLOR_UPDATED = 0xfff700;
    private const COLOR_DELETED = 0xff2d00;
    private const COLOR_RESTORED = 0xde5e00;

    /**
     * Create the event listener.
     */
    public function __construct(DiscordWebhookService $discordWeebhookService)
    {
        $this->discordWebhook = $discordWeebhookService;
    }

    /**
     * Handle the event of create.
     */
    public function handleUserCreated(UserCreated $event): void
    {
        $this->sendNotification($event->user, 'creado', auth()->user(), self::COLOR_CREATED);
    }

    /**
     * Handle the event of update.
     */
    public function handleUserUpdated(UserUpdated $event): void
    {
        $this->sendNotification($event->user, 'actualizado', auth()->user(), self::COLOR_UPDATE);
    }

    /**
     * Handle the event of delete.
     */
    public function handleUserDeleted(UserDeleted $event): void
    {
        $this->sendNotification($event->user, 'eliminado', auth()->user(), self::COLOR_DELETED);
    }

    /**
     * Handle the event of restore.
     */
    public function handleUserRestore(UserRestore $event): void
    {
        $this->sendNotification($event->user, 'restaurado', auth()->user(), self::COLOR_RESTORED);
    }

    protected function sendNotification($user, $action, $actor, $color){
        
        // Configuración del mensaje embed para Discord
        $embed = [
            'title' => "Usuario {$action}",
            'color' => hexdec($color),
            'fields' => [
                [
                    'name' => 'Id de user',
                    'value' => "{$user->id}",
                    'inline' => true,
                ],
                [
                    'name' => 'Nombre Completo',
                    'value' => "{$user->names} {$user->lastnames}",
                    'inline' => true,
                ],
                [
                    'name' => 'Correo Electronico',
                    'value' => $user->email,
                    'inline' => false,
                ],
                [
                    'name' => 'Direccion',
                    'value' => $user->address ?? 'no proporcionado',
                    'inline' => false,
                ],
                [
                    'name' => 'Realizado por',
                    'value' => "{$actor->names} {$actor->lastnames} con el id {$actor->id}",
                    'inline' => false,
                ],
            ],
            'footer' => [
                'text' => 'Notificacion realizada el ' . now()->format('d/m/y H:i')
            ],
            'timestamp' => now()->toIso8601String(),
        ];

        $this->discordWebhook->sendEmbed($embed);
    }
}
