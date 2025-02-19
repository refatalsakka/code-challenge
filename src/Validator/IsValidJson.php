<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;

#[\Attribute(\Attribute::TARGET_PROPERTY)]
final class IsValidJson extends Constraint
{
    public string $message = 'The value "{{ value }}" must be valid JSON.';
}
