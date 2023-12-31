<?php

namespace App\Presentation\Presenters;

use League\Fractal\TransformerAbstract;
use App\Presentation\Presenters\PresenterInterface;

class XmlPresenter extends TransformerAbstract implements PresenterInterface
{
    public static function transform($data)
    {
        return [
            'content' => $data,
        ];
    }

    public static function output($data)
    {
        $dataXml = self::toXml($data);
        return response($dataXml, $data["status"])->header('Content-Type', 'application/xml');
    }

    public static function toXml($data)
    {
        $xml = new \SimpleXMLElement('<root/>');
        self::arrayToXml($data, $xml);
        return $xml->asXML();
    }

    private static function arrayToXml($data, $xml)
    {
        foreach ($data as $key => $value) {
            if (is_array($value) || is_object($value)) {
                $subnode = $xml->addChild($key);
                if (is_object($value)) {
                    self::arrayToXml(json_decode(json_encode($value), true), $subnode);
                } else {
                    self::arrayToXml($value, $subnode);
                }
            } else {
                $xml->addChild($key, htmlspecialchars((string) $value));
            }
        }
    }
}
