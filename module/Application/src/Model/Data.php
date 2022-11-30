<?php

namespace Application\Model;

class Data
{
    public function dzisiaj(): string
    {
        return date('Y-m-d H:i:s');
    }

    public function dniTygodnia(): array
    {
        return [
            'Poniedziałek',
            'Wtorek',
            'Środa',
            'Czwartek',
            'Piątek',
            'Sobota',
            'Niedziela',
        ];
    }
}