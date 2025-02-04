<?php

namespace App\Models\Template\Variables;

use App\Models\School\School;
use App\Models\Template\Variable;
use Illuminate\Support\Collection;

class InstituteVariables extends VariableOperations
{
    public function __construct(private readonly ?School $instance = null)
    {
    }

    public function variables(): Collection
    {
        $instance = $this->instance;

        return collect(
            [
                new Variable('Institute ID', 'institute_id', $instance?->id, '1'),
                new Variable('Institute Name', 'institute_name', $instance?->name, 'Eximus Model School'),
                new Variable('Institute Short Name', 'institute_name', $instance?->short_name, 'EMS'),
                new Variable('Institute Address', 'institute_address', $instance?->address, '4/2, Road 1, Kallyanpur, Dhaka'),
                new Variable('Institute Motto', 'institute_motto', $instance?->motto, 'Transforming Education, Empowering Institutions'),
                new Variable('Institute Logo', 'institute_logo', $instance?->getLogo(), logo_url(null)),
                new Variable('Institute Logo HD', 'institute_logo_hd', $instance?->getLogoWatermark(), logo_url(null, true)),
            ]
        );
    }
}
