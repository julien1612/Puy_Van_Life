<?php

namespace App\Form;

use App\Entity\Location;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddLocationForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('description')
            ->add('latitude')
            ->add('longitude')
            ->add('address')
            ->add('price')
            ->add('type')
            ->add('imagePath')

        ->add('ajouter', SubmitType::class, [
        'label' => 'Ajouter le spot',
        'attr' => ['class' => 'btn btn-lg btn-primary btn-block']
    ]);

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Location::class,
        ]);
    }
}
