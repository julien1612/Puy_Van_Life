<?php

namespace App\Form;

use App\Entity\Comment;
use App\Entity\Location;
use App\Entity\User;
use Doctrine\ORM\EntityRepository;
use phpDocumentor\Reflection\Types\Integer;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Range;

class CommentForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('rating', IntegerType::class, [
                'constraints' => [
                    new Range(['min' => 0, 'max' => 10])
                ],
                'attr' => ['min' => 0, 'max' => 10, 'style' => 'width: 80px']


            ])
            ->add('comment', TextareaType::class, [
                'attr' => ['rows' => 6, 'placeholder' => 'Votre commentaire']

            ])

        ->add('submit', SubmitType::class, [
        'label' => 'Valider mon commentaire',
        'attr' => [
            'class' => 'btn btn-secondary btnForm',
        ]
    ]);

    }




    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Comment::class,
        ]);
    }
}
