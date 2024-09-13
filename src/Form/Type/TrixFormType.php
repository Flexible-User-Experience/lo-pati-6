<?php

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class TrixFormType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver): void
    {
        $uniqueId = uniqid();
        $resolver
            ->setDefined(
                [
                    'trix_id',
                    'trix_value',
                    'trix_name',
                ]
            )
            ->setDefaults(
                [
                    'trix_id' => sprintf('trix_id_%s', $uniqueId),
                    'trix_value' => '',
                    'trix_name' => sprintf('trix_name_%s', $uniqueId),
                ]
            )
        ;
    }

    public function buildView(FormView $view, FormInterface $form, array $options): void
    {
        if (array_key_exists('trix_id', $options) && array_key_exists('trix_value', $options) && array_key_exists('trix_name', $options)) {
            $view->vars['trix_id'] = $options['trix_id'];
            $view->vars['trix_value'] = $options['trix_value'];
            $view->vars['trix_name'] = $options['trix_name'];
        }
    }

    public function getBlockPrefix(): string
    {
        return 'trix_form_type';
    }
}
