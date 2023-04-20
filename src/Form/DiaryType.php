<?php

namespace App\Form;

use App\Entity\Diary;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DiaryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $dt = new \DateTime();
        $builder
            ->add('date', DateType::class, [
                'data' => new \DateTime("now")
            ])
            ->add('content', TextareaType::class, [
                'attr' => array('style' => 'width: 100%','rows' => '15','placeholder' => 'Write here')])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Diary::class,
        ]);
    }
}
