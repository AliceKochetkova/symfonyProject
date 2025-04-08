<?php
namespace App\Dto;

readonly class BlogDto
{
    public function __construct(
        public ?string $title,
        public ?string $description,
        public ?string $text,
        public ?string $tags
    ) {
    }
}
