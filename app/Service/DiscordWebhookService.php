<?php

namespace App\Service;

use Illuminate\Support\Facades\Http;

class DiscordWebhookService
{
    // Propiedad que almacenará la URL del webhook
    protected $webhookUrl;

    // Constructor que se ejecuta al crear una nueva instancia de la clase
    public function __construct(){
        // Obtiene la URL del webhook desde la configuración y la almacena
        $this->webhookUrl = config('services.discord.webhook_url');
    }

    // Método para enviar un mensaje simple a Discord
    public function sendMessage(string $message)
    {
        // Prepara los datos del mensaje con el contenido proporcionado
        $data = ['content' => $message];
        // Llama al método que envía la solicitud a Discord
        $this->sendRequest($data);
    }

    // Método para enviar un mensaje embebido (con formato)
    public function sendEmbed(array $embed)
    {
        // Prepara los datos con el embed que se enviará
        $data = ['embeds' => [$embed]];
        // Llama al método que envía la solicitud a Discord
        $this->sendRequest($data);
    }

    // Método protegido que se encarga de enviar la solicitud al webhook
    protected function sendRequest(array $data)
    {
        // Configura las opciones para la solicitud HTTP
        $options = [
            'http' => [
                // Establece el tipo de contenido como JSON
                'header'  => "Content-Type: application/json\r\n",
                // Especifica que el método de la solicitud es POST
                'method'  => 'POST',
                // Convierte los datos a formato JSON
                'content' => json_encode($data),
            ],
        ];

        // Crea un contexto de flujo con las opciones configuradas
        $context  = stream_context_create($options);
        // Envía la solicitud a la URL del webhook
        file_get_contents($this->webhookUrl, false, $context);
    }
}