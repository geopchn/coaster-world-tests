<?php

namespace App\Validator;

use Attribute;
use Symfony\Component\Validator\Constraint;

#[Attribute(Attribute::TARGET_PROPERTY)]
class TemporaryEmail extends Constraint
{
    public $message = 'Ce type d\'adresse e-mail n\'est pas autorisée';
}
