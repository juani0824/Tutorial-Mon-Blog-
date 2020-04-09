<?php

namespace App\Form;

use App\Entity\Article;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;

class AjoutArticleFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre') 
            ->add('slug')
            ->add('contenu', CKEditorType::class)                 
           ->add('imageFile', VichImageType::class,[
               'label' => 'mise en avant'
           ])
            ->add('Envoyer', SubmitType::class)
           
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}
