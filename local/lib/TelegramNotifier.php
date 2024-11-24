<?php

namespace Local\Lib;

use Exception;

class TelegramNotifier
{
    private string $botToken;

    public function __construct()
    {
        $this->botToken = TG_BOT_TOKEN;
    }

    /**
     * @throws Exception
     */
    public function sendMessage($chatId, $message)
    {
        $url = "https://api.telegram.org/bot{$this->botToken}/sendMessage";

        $params = [
            "chat_id" => $chatId,
            "text" => $message,
        ];

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
        $response = curl_exec($ch);
        curl_close($ch);

        $result = json_decode($response, true);

        if (!$result || !$result["ok"]) {
            throw new Exception("Ошибка отправки сообщения: " . ($result["description"] ?? "Неизвестная ошибка"));
        }

        return $result;
    }
}
