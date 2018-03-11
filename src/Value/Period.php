<?php


namespace App\Value;


class Period
{
    /**
     * @var \DateTimeImmutable
     */
    private $start;

    /**
     * @var \DateTimeImmutable
     */
    private $end;

    public function __construct(\DateTimeImmutable $start, \DateTimeImmutable $end)
    {
        $this->start = $start;
        $this->end = $end;
    }

    /**
     * @return \DateTimeImmutable
     */
    public function getStart(): \DateTimeImmutable
    {
        return $this->start;
    }

    /**
     * @return \DateTimeImmutable
     */
    public function getEnd(): \DateTimeImmutable
    {
        return $this->end;
    }


}