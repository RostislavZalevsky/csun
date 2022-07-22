<?php

namespace App\Data\Models;

use DateTime;

class Term
{
    public Semester $semester;
    protected ?int $year;

    // set default parameters
    public function __construct(Semester $semester = null, int $year = null)
    {
        // setting
        $this->semester = $semester ?? self::getCurrentSemester();
        $this->setYear($year ?? self::getCurrentYear());
    }

    public function __set($property, $value) {

        if (property_exists($this, $property)) {
            switch ($property)
            {
                default:
                    $this->$property = $value;
                    return $this;

                case 'year':
                    $this->setYear($value);
                    return $this;
            }
        }

        return $this;
    }

    //TODO: It does not allow to set the wrong year of semester, it will set min/max year if the year is invalid.
    public function setYear(int $value): int
    {
        if ($value < self::getMinYear()) {
            $this->year = self::getMinYear();
        }
        elseif ($value > self::getMaxYear()) {
            $this->year = self::getMaxYear();
        }
        else {
            $this->year = $value;
        }

        return $this->year; // TODO: optional
    }

    public function getApiQuery(): string
    {
        return '/terms/' . $this->semester->name . '-' . $this->year;
    }

    public static function getMinYear(): int
    {
        return 2012;
    }

    public static function getMaxYear(): int
    {
        return (int)date('Y') + 1;
    }

    public static function getDefaultYear(): int
    {
        return 2022;
    }

    public static function getDefaultSemester(): Semester
    {
        return Semester::Spring;
    }

    public static function getCurrentYear(): int
    {
        return date('Y');
    }

    public static function getCurrentSemester(): Semester
    {
        $today = new DateTime();

        $spring = new DateTime('January 15');
        $summer = new DateTime('June 1');
        $fall = new DateTime('August 15');
        $winter = new DateTime('December 25');

        return match (true) {
            $today >= $spring && $today < $summer => Semester::Spring,
            $today >= $summer && $today < $fall => Semester::Summer,
            //$today >= $fall && $today < $winter => Semester::Fall,

            default => Semester::Fall,
        };
    }
}

// TODO: need to move enum to separate file
enum Semester: string // Half year, maybe not quarters?
{
    case Fall = 'Fall';
    //case Winter = 'Winter'; // ?
    case Spring = 'Spring';
    case Summer = 'Summer';

    public static function getThisByName($name): Semester
    {
        foreach (Semester::cases() as $s)
        {
            if ($s->name == ucwords(strtolower($name))) return $s;
        }

        return Term::getCurrentSemester();
    }
}
