<?php

namespace THL\OnCallBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ActorType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('email')
            ->add('order_index')
            ->add('is_active')
            ->add('reference_date')
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'THL\OnCallBundle\Entity\Actor'
        ));
    }

    public function getName()
    {
        return 'thl_oncallbundle_actortype';
    }
}
