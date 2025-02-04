<?php

namespace App\Models\Template\Variables;

use App\Models\Template\Variable;
use Illuminate\Support\Collection;

abstract class VariableOperations
{
    protected array $variables = [];

    /**
     * @return Collection<Variable>
     */
    public abstract function variables(): Collection;

    public function bind(string $html, bool $preview = false): string
    {
        $variables = $this->variables();

        return str_replace(
            $variables->map->placeholderCode()->toArray(),
            $variables->pluck($preview ? 'exampleValue' : 'boundValue')->toArray(),
            $html
        );
    }
}
