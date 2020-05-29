<?php

namespace App\Form;

use App\Entity\Articles;
use App\Entity\Magasin;
use App\Entity\Stock;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class StockType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('quantite')
            ->add('produit', EntityType::class, [
                'choice_label' => function(Articles $article) {
                        return $article->getTitre()." - ".$article->getDescription();
                    } ,
                'class' => Articles::class
            ])
            ->add('magasin', EntityType::class, [
                'choice_label' => 'nom',
                'class' => Magasin::class
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Stock::class,
        ]);
    }
}
