<?php

namespace AppBundle\Form;

use AppBundle\Entity\Region;
use AppBundle\Entity\Ville;

use AppBundle\Entity\Category;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;

class PropertySearchType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('price', IntegerType::class, array(
                'attr'=> array('class'=> 'form-control'),
                'required'=> false,
                'label'=> 'Prix max (DT)'
            ))
            ->add('roomNumber', IntegerType::class, array(
                'label'=> 'Nb chambre',
                'required'=> false,
            ))
            ->add('area', IntegerType::class, array(
                'required'=> false,
                'label'=> 'Superficie Max'
            ))
            ->add('ville', EntityType::class, array(
                'class'=> Ville::class,
                'choice_label'=> 'name',
                'placeholder'=> 'Choisr ville',
                'required'=> false,
            ))
            ->add('category', EntityType::class, array(
                'class'=> Category::class,
                'choice_label'=>'name',
                'placeholder'=>'choisir category',
                'required'=> false,
            ))
            ->add('operation', ChoiceType::class, array(
                'choices'=> array(
                    'Location'=> 'Location',
                    'Vente'=> 'Vente',
                ),
                'placeholder'=> 'Opération',
                'required'=> false,
            ))
        ;
        $formModifier = function (FormInterface $form, Ville $vile = null) {

            $regions = null === $vile ? array() : $vile->getRegions();

            $form->add('region', EntityType::class, array(
                'class' => Region::class,
                'placeholder' => '-- choisir une region---',
                'choice_label'=> 'name',
                'choices' => $regions,
            ));
        };

        $builder->addEventListener(
            FormEvents::PRE_SET_DATA,
            function (FormEvent $event) use ($formModifier) {
                // this would be your entity, i.e.
                $data = $event->getData();
                $formModifier($event->getForm(), $data->getVille());
            }
        );

        $builder->get('ville')->addEventListener(
            FormEvents::POST_SUBMIT,
            function (FormEvent $event) use ($formModifier) {

                $ville = $event->getForm()->getData();


                $formModifier($event->getForm()->getParent(), $ville);
            }
        );

        $builder->addEventListener(FormEvents::POST_SUBMIT, function (FormEvent $event) {
            $event->stopPropagation();
        }, 900);
    }


    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Property'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return null;
    }


}
