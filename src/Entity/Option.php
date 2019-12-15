<?php

namespace App\Entity;

use DateTime;
use JMS\Serializer\Annotation\Type;

class Option{

     /**
     * @Type("DateTime")
     */
     private $start;

     /**
     * @Type("bool")
     */
     private $allday;

    /**
     * @Type("DateTime")
     */
     private $date;

     /**
     * @Type("bool")
     */
     private $available;

     public function getStart(): DateTime{
         return $this->start;
     }

     public function isAllDay(): bool{
         return $this->allday;
     }

     public function getDate(): DateTime{
         return $this->date;
     }

     public function isAvailable(): bool{
         return $this->available;
     }
}