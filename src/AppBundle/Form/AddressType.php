<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddressType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstName', TextType::class)
            ->add('lastName', TextType::class)
            ->add('street', TextType::class)
            ->add('streetNumber', IntegerType::class)
            ->add('zip', IntegerType::class)
            ->add('country', TextType::class)
            ->add('phoneNumber', IntegerType::class)
            ->add('birthday', DateType::class)
            ->add('email', EmailType::class)
            ->add('picture', FileType::class, [
                'label' => 'Contact Picture',
//                'data_class' => null,
                'required' => false,
                'label_attr' => ['class' => 'form-horizontal']
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'AppBundle\Entity\Address'
        ]);
    }

    public function getBlockPrefix()
    {
        return 'app_bundle_address_type';
    }
}
