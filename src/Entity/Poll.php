<?php 

namespace App\Entity;

use DateTime;
use JMS\Serializer\Annotation\Type;

class Poll{

    /**
     * @Type("string")
     */
    private $id;

    /**
     * @Type("string")
     */
    private $adminKey;

    /**
     * @Type("DateTime")
     */
    private $latestChange;

    /**
     * @Type("DateTime")
     */
    private $initiated;

    /**
     * @Type("integer")
     */
    private $participantsCount;

    /**
     * @Type("integer")
     */
    private $inviteesCount;

    /**
     * @Type("string")
     */
    private $type;

    /**
     * @Type("string")
     */
    private $preferencesType;

    /**
     * @Type("string")
     */
    private $state;

    /**
     * @Type("string")
     */
    private $locale;

    /**
     * @Type("string")
     */
    private $title;

    /**
     * @Type("array<App\Entity\Option>")
     */
    //private $options;

    public function getId(): string{
        return $this->id;
    }

    public function getAdminKey(): ?string{
        return $this->adminKey;
    }

    public function getLatestChange(): DateTime{
        return $this->latestChange;
    }

    public function getInitiated(): DateTime{
        return $this->initiated;
    }

    public function getParticipantsCount(): int{
        return $this->participantsCount;
    }

    public function getInviteesCount(): int{
        return $this->inviteesCount;
    }

    public function getType(): string{
        return $this->type;
    }

    public function getPreferencesType(): string{
        return $this->preferencesType;
    }

    public function getState(): string{
        return $this->state;
    }

    public function getLocale(): ?string{
        return $this->locale;
    }

    public function getTitle(): string{
        return $this->title;
    }

    public function getOptions(): array{
        return $this->options;
    }

    public function isAvailable(DateTime $date): bool{
        return false === empty(array_filter(array_map(
            function(Option $option) use ($date){
                dump($option,$date);
                $diff = $date->diff($option->getDate());
                return $diff->days === false;
            },$this->getOptions()
            )));
    }
}