<?php

namespace App\Data\Models;

class Classes
{
    public string $subject;
    public ?int $catalogNumber;

    public function __construct(string $subject = null, int $catalogNumber = null)
    {
        $this->subject = $subject;
        $this->catalogNumber = $catalogNumber;
    }

    public function getApiQuery(): string
    {
        if (isNullOrEmpty($this->subject)) return '';

        $number = $this->catalogNumber && $this->catalogNumber > 0 ? "-$this->catalogNumber" : '';

        return "/classes/$this->subject$number";
    }
}
