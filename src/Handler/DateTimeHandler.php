<?php

namespace App\Handler;

use DateTime;
use JMS\Serializer\Context;
use JMS\Serializer\GraphNavigator;
use JMS\Serializer\Handler\SubscribingHandlerInterface;
use JMS\Serializer\JsonSerializationVisitor;

class DateTimeHandler implements SubscribingHandlerInterface{

    public static function getSubscribingMethods()
    {
        dump("ok");
        die;
        return array(
            array(
                'direction'=>GraphNavigator::DIRECTION_SERIALIZATION,
                'format'=>'json',
                'type'=> 'DateTime',
                'method'=>'serializeDateTimeToJson'
            ),
            array(
                'direction'=>GraphNavigator::DIRECTION_DESERIALIZATION,
                'format'=>'json',
                'type'=> 'DateTime',
                'method'=>'deserializeDateTimeFromJson'
            )
        );
    }

    public function serializeDateTimeToJson(JsonSerializationVisitor $visitor,DateTime $date, array $type,Context $context){
        return $date->getTimestamp();
    }

    public function deserializeDateTimeFromJson(JsonSerializationVisitor $visitor,$dateAsString, array $type,Context $context){
        return new DateTime();
    }
}