<?php

namespace App\DTOs\Task;

class TaskData
{
    // konstruktor a tömbből való létrehozáshoz
    public function __construct(
        //csak olvasható mezők és nem módosíthatók
        public readonly string $title,
        public readonly ?string $description
    ){}

    // statikus metódus tömbből való létrehozáshoz
    public static function fromArray(array $data): self
    {
        // létrehoz egy új TaskData objektumot a megadott tömb adataival
        return new self(
            title: $data['title'],
            description: $data['description'] ?? null
        );
    }
}
