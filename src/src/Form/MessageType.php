<?php

namespace App\Form;

use App\Entity\Message;
use App\Form\ApplicationType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class MessageType extends ApplicationType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'firstName',
                TextType::class,
                $this->getConfiguration("Prénom","Veuillez indiquer votre prénom")
                )
            ->add(
                'lastName',
                TextType::class,
                $this->getConfiguration("Nom","Veuillez indiquer votre prénom")
                )
            ->add(
                'object',
                TextType::class,
                $this->getConfiguration("Objet du message","Veuillez indiquer l'objet du message")
                )
            ->add(
                'email',
                TextType::class,
                $this->getConfiguration("Email","Veuillez indiquer votre email")
                )
            ->add(
                'content',
                TextareaType::class,
                $this->getConfiguration("Message","Votre message ...")
                )
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Message::class,
        ]);
    }
}
