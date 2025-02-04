<?php

namespace App\Models\Template;

class Variable
{
    public function __construct(
        public string $label,
        public string $placeholder,
        public mixed $boundValue = null,
        public ?string $exampleValue = null,
        public ?string $description = null,
    ) {
    }

    public function placeholderCode(): string
    {
        return '{{' . $this->placeholder . '}}';
    }
}
