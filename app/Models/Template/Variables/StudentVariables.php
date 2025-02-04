<?php

namespace App\Models\Template\Variables;

use App\Models\Template\Variable;
use App\Models\User\Student\Student;
use Illuminate\Support\Collection;

class StudentVariables extends VariableOperations
{
    public function __construct(private readonly ?Student $instance = null)
    {
    }

    public function variables(): Collection
    {
        $instance = $this->instance;

        return collect(
            [
                new Variable('Student ID', 'student_id', $instance?->display_id, '20243B01'),
            ]
        );
    }
}
