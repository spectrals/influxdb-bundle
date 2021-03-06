<?php

namespace Algatux\InfluxDbBundle\Form\Type;

use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Choice type listing available field keys of a measurement.
 */
final class FieldKeyType extends AbstractInfluxChoiceType
{
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);

        $resolver
            ->setRequired('measurement')
            ->setDefaults([
                'choices' => function (Options $options) {
                    return $this->loadChoicesFromQuery(
                        sprintf(
                            'SELECT fieldKey FROM "default"._fieldKeys WHERE _name = \'%s\'',
                            $options['measurement']
                        ),
                        'fieldKey',
                        $options['connection']
                    );
                },
            ])
            ->setAllowedTypes('measurement', ['string'])
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'influx_field_key';
    }
}
