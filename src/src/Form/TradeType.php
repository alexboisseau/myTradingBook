<?php

namespace App\Form;

use App\Entity\Trade;
use App\Form\ApplicationType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class TradeType extends ApplicationType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'action',
                TextType::class,
                $this->getConfiguration("Action","Indiquez sur quelle action vous avez tradé")
                )
            ->add(
                'position',
                TextType::class,
                $this->getConfiguration("Position","Achat ou Vente")
                )
            ->add(
                'enterPrice',
                NumberType::class,
                $this->getConfiguration("Prix d'entrée","Indiquez le prix d'entrée")
                )
            ->add(
                'exitPrice',
                NumberType::class,
                $this->getConfiguration("Prix de sortie","Indiquez le prix de sortie")
                )
            ->add(
                'comment',
                TextareaType::class,
                $this->getConfiguration("Commentaire","Ajoutez un commentaire quelconque ")
                )
            ->add(
                'lots',
                NumberType::class,
                $this->getConfiguration("Lots","Nombre de lots prit pour le trade")
                )
            ->add(
                'profit',
                NumberType::class,
                $this->getConfiguration("Bénéfice","Indiquez le bénéfice de ce trade (mettez 0 si le trade est en cours)")
                )
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Trade::class,
        ]);
    }
}
