<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class OpinionForm extends AbstractType {

  public function buildForm(FormBuilderInterface $builder, array $options)
  {
    $builder->add('comentario', TextareaType::class, [ 'attr' => ['placeholder' => 'Me encanta Maleteo, es simplemente genial!','label'=> 'Introduzca su comentario']]);
    $builder->add('autor', TextType::class, [ 'attr' => ['placeholder' => 'Nombre y apellidos', 'label'=> 'Autor']]);
    $builder->add('ciudad', TextType::class, [ 'attr' => ['label'=> 'Ciudad']]);
    $builder->add('ciudad', ChoiceType::class, [
      'choices' => [
      'Madrid' => 'Madrid',
      'Barcelona' => 'Barcelona',
      'Sevilla' => 'Sevilla'
      ],
      'placeholder' => 'Elige tu ciudad', 'label'=> 'Ciudad'
      ]);
  }

} 