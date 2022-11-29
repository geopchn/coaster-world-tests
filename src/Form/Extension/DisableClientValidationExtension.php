<?php

namespace App\Form\Extension;

use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;

class DisableClientValidationExtension extends AbstractTypeExtension
{
    public function buildView(FormView $view, FormInterface $form, array $options): void
    {
        if (!$form->isRoot()) {
            return;
        }

        $attr = ['novalidate' => 'novalidate'];
        $view->vars['attr'] = array_merge($view->vars['attr'], $attr);
    }

    public static function getExtendedTypes(): iterable
    {
        return [FormType::class];
    }
}
