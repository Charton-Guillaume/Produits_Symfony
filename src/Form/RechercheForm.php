<?php


namespace App\Form;


use App\Donnees\DonneesRecherche;
use App\Entity\Categorie;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RechercheForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
       $builder
           ->add('motCle', TextType::class,
               ['label' => false,
                   'required' => false,
                   'attr' => ['placeholder' => 'Rechercher']])
           ->add('categories', EntityType::class,
               ['label' => false,'required' => false,
                   'class' => Categorie::class,
                   'expanded' => true,
                   'multiple' => true,
                   'choice_label' => 'nom'])
           -> add('prixMin', NumberType::class,
               ['label' => false,
                   'required' => false,
                   'attr' => ['placeholder' => 'Prix minimum']])
           -> add('prixMax', NumberType::class,
               ['label' => false,
                   'required' => false,
                   'attr' => ['placeholder' => 'Prix maximun']])
           -> add('promo', CheckboxType::class,
               ['label' => 'En promotion','required' => false,]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
       $resolver->setDefaults([
           'data_class'=>DonneesRecherche::class,
           'method'=>'GET',
           'csrf_protection'=>false,
       ]);
    }
    public function getBlockPrefix(){
        return '';
    }

}