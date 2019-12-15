<?php

namespace App\Handler;

use DateTime;
use JMS\Serializer\Context;
use JMS\Serializer\GraphNavigator;
use JMS\Serializer\Handler\SubscribingHandlerInterface;
use JMS\Serializer\JsonDeserializationVisitor;
use JMS\Serializer\JsonSerializationVisitor;

class DateTimeHandler implements SubscribingHandlerInterface{

    public static function getSubscribingMethods()
    {
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
        return $date->getTimestamp()*1000;
    }

    public function deserializeDateTimeFromJson(JsonDeserializationVisitor $visitor,$dateAsString, array $type,Context $context){
        $date = new DateTime();
        $date->setTimestamp(floor($dateAsString/1000));
        return $date;
    }
}