<?php

namespace App\Form;

use App\DTO\ProfileDetailsDTO;
use App\Entity\City;
use App\Form\DataTransformer\UserToProfileDetailsDTO;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProfileDetailsType extends AbstractType
{
    /**
     * @var UserToProfileDetailsDTO
     */
    private $userToProfileDetailsDTOTransformer;

    /**
     * ProfileDetailsType constructor.
     * @param UserToProfileDetailsDTO $userToProfileDetailsDTOTransformer
     */
    public function __construct(UserToProfileDetailsDTO $userToProfileDetailsDTOTransformer)
    {
        $this->userToProfileDetailsDTOTransformer = $userToProfileDetailsDTOTransformer;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, ['empty_data' => 'Default value'])
            ->add('lastName', TextType::class, ['empty_data' => 'Default value'])
            ->add('description', TextareaType::class, ['empty_data' => 'Default value'])
            ->add('city', EntityType::class, [
                'class' => City::class,
                'choice_label' => 'name'
            ])
            ->add('save', SubmitType::class, ['label' => 'Išsaugoti'])
            ->addModelTransformer($this->userToProfileDetailsDTOTransformer);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ProfileDetailsDTO::class,
        ]);
    }
}
