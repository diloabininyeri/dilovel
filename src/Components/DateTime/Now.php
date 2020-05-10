<?php /** @noinspection PhpUnhandledExceptionInspection */

namespace App\Components\DateTime;

use Carbon\Carbon;
use DateInterval;
use DateTime;
use Exception;

/**
 * Class Now
 * @author  dılo sürücü <berxudar@gmail.com>
 */
class Now
{

    /**
     * @var DateTime
     */
    private DateTime $dateTime;

    /**
     * Now constructor.
     * @throws Exception
     */
    public function __construct()
    {
        $this->dateTime = new DateTime('now');
    }


    /**
     * @param int $year
     * @return Now
     * @throws Exception
     * @noinspection PhpUnused
     */
    public function addYear(int $year): self
    {
        $this->dateTime->add(new DateInterval('P' . $year . 'Y'));

        return $this;
    }

    /**
     * @noinspection PhpUnused
     * @param int $month
     * @return Now
     * @throws Exception
     * @noinspection PhpUnused
     */
    public function addMonth(int $month):self
    {
        $this->dateTime->add(new DateInterval('P' . $month . 'M'));

        return $this;
    }

    /**
     * @param int $day
     * @return $this
     * @throws Exception
     */
    public function addDay(int $day): self
    {
        $this->dateTime->add(new DateInterval('P' . $day . 'D'));
        return $this;
    }

    /**
     * @noinspection PhpUnused
     * @param int $week
     * @return $this
     * @throws Exception
     */
    public function addWeek(int $week): self
    {
        return $this->addDay($week * 7);
    }

    /**
     * @noinspection PhpUnused
     * @param int $second
     * @return $this
     * @throws Exception
     */
    public function addSecond(int $second): self
    {
        $this->dateTime->add(new DateInterval('PT' . $second . 'S'));
        return $this;
    }

    /**
     * @param int $minute
     * @return $this
     * @throws Exception
     */
    public function addMinute(int $minute): self
    {
        $this->dateTime->add(new DateInterval('PT' . $minute . 'M'));
        return $this;
    }

    /**
     * @param int $hour
     * @return $this
     * @throws Exception
     */
    public function addHour(int $hour): self
    {
        $this->dateTime->add(new DateInterval('PT' . $hour . 'H'));
        return $this;
    }


    /**
     * @return string
     */
    public function get(): string
    {
        return $this->dateTime->format('Y-m-d H:i:s');
    }

    /**
     * @return Carbon
     * @throws Exception
     */
    public function carbon(): Carbon
    {
        return new Carbon($this->get());
    }

    /**
     * @param string $locale
     */
    public function setLocal(string $locale):void
    {
        Carbon::setLocale($locale);
    }

    /**
     * @param $date
     * @return string
     * @noinspection PhpUnused
     */
    public function diffForHumans($date=null):string
    {
        return Carbon::parse($date ?: $this->get())->diffForHumans();
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->get();
    }
}
