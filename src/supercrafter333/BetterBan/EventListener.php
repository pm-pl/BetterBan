<?php

namespace supercrafter333\BetterBan;

use pocketmine\event\Listener;
use supercrafter333\BetterBan\Events\BBBanEvent;
use supercrafter333\BetterBan\Events\BBBanIpEvent;
use supercrafter333\BetterBan\Events\BBEditbanEvent;
use supercrafter333\BetterBan\Events\BBEditipbanEvent;
use supercrafter333\BetterBan\Events\BBKickEvent;
use supercrafter333\BetterBan\Events\BBPardonEvent;
use supercrafter333\BetterBan\Events\BBPardonIpEvent;

/**
 *
 */
class EventListener implements Listener
{

    /**
     * @param BBBanEvent $event
     */
    public function onBBBan(BBBanEvent $event)
    {
        if ($event->isCancelled()) return;
        $event->sendDiscordWebhookMessage();
    }

    /**
     * @param BBEditbanEvent $event
     */
    public function onBBEditban(BBEditbanEvent $event)
    {
        if ($event->isCancelled()) return;
        $event->sendDiscordWebhookMessage();
    }

    /**
     * @param BBPardonEvent $event
     */
    public function onBBPardon(BBPardonEvent $event)
    {
        if ($event->isCancelled()) return;
        $event->sendDiscordWebhookMessage();
    }

    /**
     * @param BBBanIpEvent $event
     */
    public function onBBIpBan(BBBanIpEvent $event)
    {
        if ($event->isCancelled()) return;
        $event->sendDiscordWebhookMessage();
    }

    /**
     * @param BBEditipbanEvent $event
     */
    public function onBBEditIpBan(BBEditipbanEvent $event)
    {
        if ($event->isCancelled()) return;
        $event->sendDiscordWebhookMessage();
    }

    /**
     * @param BBPardonIpEvent $event
     */
    public function onBBPardonIp(BBPardonIpEvent $event)
    {
        if ($event->isCancelled()) return;
        $event->sendDiscordWebhookMessage();
    }

    /**
     * @param BBKickEvent $event
     */
    public function onBBKick(BBKickEvent $event)
    {
        if ($event->isCancelled()) return;
        $event->sendDiscordWebhookMessage();
    }
}