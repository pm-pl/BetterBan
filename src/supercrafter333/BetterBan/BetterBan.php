<?php

namespace supercrafter333\BetterBan;

use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;
use supercrafter333\BetterBan\Commands\BanCommand;
use supercrafter333\BetterBan\Commands\BaninfoCommand;
use supercrafter333\BetterBan\Commands\BanlogCommand;
use supercrafter333\BetterBan\Commands\EditbanCommand;

/**
 * Class BetterBan
 * @package supercrafter333\BetterBan
 */
class BetterBan extends PluginBase
{

    /**
     * @var
     */
    protected static $instance;

    public const VERSION = "2.0.0";

    public function onEnable()
    {
        self::$instance = $this;
        $this->saveResource("config.yml");
        $this->versionCheck(self::VERSION);
        $cmdMap = $this->getServer()->getCommandMap();
        $pmmpBanCmd = $cmdMap->getCommand("ban");
        $cmdMap->unregister($pmmpBanCmd);
        $cmdMap->registerAll("BetterBan", [
            new BanCommand("ban"),
            new BanlogCommand("banlog"),
            new BaninfoCommand("baninfo"),
            new EditbanCommand("editban")
        ]);
    }

    /**
     * @return static
     */
    public static function getInstance(): self
    {
        return self::$instance;
    }

    /**
     * @return Config
     */
    public function getConfig(): Config
    {
        $cfg = new Config($this->getDataFolder() . "config.yml", Config::YAML);
        return $cfg;
    }

    /**
     * @param $version
     */
    private function versionCheck($version)
    {
        if (!$this->getConfig()->exists("version") || !$this->getConfig()->get("version") == $version) {
            $this->getLogger()->debug("OUTDATED CONFIG.YML!! You config.yml is outdated! Your config.yml will automatically updated!");
            unlink($this->getConfig()->getPath());
            $this->saveResource("config.yml");
            $this->getConfig()->reload();
            $this->getLogger()->debug("confg.yml Updated for version: §b$version");
        }
    }

    /**
     * @return Config
     */
    public function getBanLogs()
    {
        return new Config($this->getDataFolder() . "banLogs.yml", Config::YAML);
    }

    /**
     * @param string $playerName
     */
    public function addBanToBanlog(string $playerName)
    {
        $log = $this->getBanLogs();
        if ($log->exists($playerName)) {
            $log->set($playerName, intval($log->get($playerName) +1));
            $log->save();
        } else {
            $log->set($playerName, 1);
            $log->save();
        }
    }

    /**
     * @param string $playerName
     * @return int
     */
    public function getBanLogOf(string $playerName): int
    {
        $bans = $this->getBanLogs()->exists($playerName) ? $this->getBanLogs()->get($playerName) : 0;
        return $bans;
    }

    /**
     * @param string $string
     * @return array|null
     * @throws \Exception
     */
    public function stringToTimestamp(string $string): ?array{
        /**
         * Rules:
         * Integers without suffix are considered as seconds
         * "s" is for seconds
         * "m" is for minutes
         * "h" is for hours
         * "d" is for days
         * "w" is for weeks
         * "mo" is for months
         * "y" is for years
         */
        if(trim($string) === ""){
            return null;
        }
        $t = new \DateTime();
        preg_match_all("/[0-9]+(y|mo|w|d|h|m|s)|[0-9]+/", $string, $found);
        if(count($found[0]) < 1){
            return null;
        }
        $found[2] = preg_replace("/[^0-9]/", "", $found[0]);
        foreach($found[2] as $k => $i){
            switch($c = $found[1][$k]){
                case "y":
                case "w":
                case "d":
                    $t->add(new \DateInterval("P" . $i. strtoupper($c)));
                    break;
                case "mo":
                    $t->add(new \DateInterval("P" . $i. strtoupper(substr($c, 0, strlen($c) -1))));
                    break;
                case "h":
                case "m":
                case "s":
                    $t->add(new \DateInterval("PT" . $i . strtoupper($c)));
                    break;
                default:
                    $t->add(new \DateInterval("PT" . $i . "S"));
                    break;
            }
            $string = str_replace($found[0][$k], "", $string);
        }
        return [$t, ltrim(str_replace($found[0], "", $string))];
    }

    /**
     * @param string $string
     * @param \DateTime $time
     * @return array|null
     * @throws \Exception
     */
    public function stringToTimestampAdd(string $string, \DateTime $time): ?array{
        /**
         * Rules:
         * Integers without suffix are considered as seconds
         * "s" is for seconds
         * "m" is for minutes
         * "h" is for hours
         * "d" is for days
         * "w" is for weeks
         * "mo" is for months
         * "y" is for years
         */
        if(trim($string) === ""){
            return null;
        }
        $t = $time;
        preg_match_all("/[0-9]+(y|mo|w|d|h|m|s)|[0-9]+/", $string, $found);
        if(count($found[0]) < 1){
            return null;
        }
        $found[2] = preg_replace("/[^0-9]/", "", $found[0]);
        foreach($found[2] as $k => $i){
            switch($c = $found[1][$k]){
                case "y":
                case "w":
                case "d":
                    $t->add(new \DateInterval("P" . $i. strtoupper($c)));
                    break;
                case "mo":
                    $t->add(new \DateInterval("P" . $i. strtoupper(substr($c, 0, strlen($c) -1))));
                    break;
                case "h":
                case "m":
                case "s":
                    $t->add(new \DateInterval("PT" . $i . strtoupper($c)));
                    break;
                default:
                    $t->add(new \DateInterval("PT" . $i . "S"));
                    break;
            }
            $string = str_replace($found[0][$k], "", $string);
        }
        return [$t, ltrim(str_replace($found[0], "", $string))];
    }

    /**
     * @param string $string
     * @param \DateTime $time
     * @return array|null
     * @throws \Exception
     */
    public function stringToTimestampReduce(string $string, \DateTime $time): ?array{
        /**
         * Rules:
         * Integers without suffix are considered as seconds
         * "s" is for seconds
         * "m" is for minutes
         * "h" is for hours
         * "d" is for days
         * "w" is for weeks
         * "mo" is for months
         * "y" is for years
         */
        if(trim($string) === ""){
            return null;
        }
        $t = $time;
        preg_match_all("/[0-9]+(y|mo|w|d|h|m|s)|[0-9]+/", $string, $found);
        if(count($found[0]) < 1){
            return null;
        }
        $found[2] = preg_replace("/[^0-9]/", "", $found[0]);
        foreach($found[2] as $k => $i){
            switch($c = $found[1][$k]){
                case "y":
                case "w":
                case "d":
                    $t->sub(new \DateInterval("P" . $i. strtoupper($c)));
                    break;
                case "mo":
                    $t->sub(new \DateInterval("P" . $i. strtoupper(substr($c, 0, strlen($c) -1))));
                    break;
                case "h":
                case "m":
                case "s":
                    $t->sub(new \DateInterval("PT" . $i . strtoupper($c)));
                    break;
                default:
                    $t->sub(new \DateInterval("PT" . $i . "S"));
                    break;
            }
            $string = str_replace($found[0][$k], "", $string);
        }
        return [$t, ltrim(str_replace($found[0], "", $string))];
    }
}