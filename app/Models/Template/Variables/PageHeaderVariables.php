<?php

namespace App\Models\Template\Variables;

use App\Models\School\School;
use App\Models\Template\Template;
use App\Models\Template\Variable;
use Illuminate\Support\Collection;

class PageHeaderVariables extends VariableOperations
{
    public function __construct(private readonly ?Template $instance = null, private readonly ?School $school = null)
    {
    }

    public function variables(): Collection
    {
        return collect(
            [
                new Variable('Page Header', 'page_header', '<h1>Eximus Model School</h1>'),
            ]
        );
    }
}
