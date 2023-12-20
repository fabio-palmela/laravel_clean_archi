<?php
namespace App\Presentation\Presenters;

use Symfony\Component\HttpFoundation\Response;

class JsonPresenter implements PresenterInterface
{
    public static function output($data)
    {
        $status = isset($data["status"]) ? $data["status"] : 200;
        $headers = isset($data["headers"]) ? $data["headers"] : [];
        $options = isset($data["options"]) ? $data["options"] : 0;
        return response()->json([
            'message' => $data["msg"],
            'content' => $data["content"]
        ], $status, $headers, $options);
    }
}
