<?php
namespace App\Presentation\Presenters;

use stdClass;

class JsonPresenter
{
    public static function toJson(string $msg, object $content = new stdClass()): array
    {
        return [
            'message' => $msg,
            'content' => $content
        ];
    }
}
