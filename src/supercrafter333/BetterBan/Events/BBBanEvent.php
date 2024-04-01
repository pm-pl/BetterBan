<?php

namespace supercrafter333\BetterBan\Events;

use pocketmine\event\Cancellable;
use pocketmine\event\CancellableTrait;
use pocketmine\event\Event;
use supercrafter333\BetterBan\BetterBan;

/**
 * Class BBBanEvent
 * @package supercrafter333\BetterBan\Events
 */
class BBBanEvent extends Event implements Cancellable
{
    use CancellableTrait;

    /**
     * BBBanEvent constructor.
     * @param string $target
     * @param string $source
     * @param string|null $reason
     */
    public function __construct(private string $target, private string $source, private string|null $reason = null)
    {
        $this->eventName = "BBBanEvent";
    }

    /**
     * Get the Target Player-Name of the ban
     *
     * @return string
     */
    public function getTarget(): string
    {
        return $this->target;
    }

    /**
     * Get the Source Name of the ban
     *
     * @return string
     */
    public function getSource(): string
    {
        return $this->target;
    }

    /**
     * Get the Reason of the ban
     *
     * @return string|null
     */
    public function getReason(): ?string
    {
        return $this->target;
    }

    /**
     * Set the Target Player-Name of the Ban
     *
     * @param string $target
     */
    public function setTarget(string $target): void
    {
        $this->target = $target;
    }

    /**
     * Set the Source Player-Name of the Ban
     *
     * @param string $source
     */
    public function setSource(string $source): void
    {
        $this->source = $source;
    }

    /**
     * Set the Reason of the Ban
     *
     * @param string|null $reason
     */
    public function setReason(string $reason = null): void
    {
        $this->reason = $reason;
    }

    /**
     * Send the Discord-Webhook Message
     */
    public function sendDiscordWebhookMessage(): void
    {
        $reason = $this->reason === null ? "" : $this->reason;
        BetterBan::getInstance()->sendBanMessageToDC($this->target, $this->source, $reason);
    }
}