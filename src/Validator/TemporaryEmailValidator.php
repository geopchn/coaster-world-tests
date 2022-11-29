<?php

namespace App\Validator;

use StephaneBour\Disposable\Domains;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class TemporaryEmailValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint): void
    {
        if (null === $value || '' === $value) {
            return;
        }

        if (Domains::isDisposable($value)) {
            $this->context->buildViolation($constraint->message)
                ->addViolation();
        }
    }
}
