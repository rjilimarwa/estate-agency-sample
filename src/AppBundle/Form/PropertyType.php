<?php

namespace AppBundle\Form;

use AppBundle\Entity\Region;
use AppBundle\Entity\Ville;

use AppBundle\Entity\Category;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;

class PropertyType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, array(
                'label'=> 'Titre'
            ))
            ->add('price', IntegerType::class, array(
                'label'=> 'Prix',
                'attr'=> array('class'=> 'form-control'),
                'required'=> false,
            ))
            ->add('description')
            ->add('area')
            ->add('roomNumber', IntegerType::class, array(
                'required'=> false,
                'label'=> 'Chambres'
            ))
            ->add('livingRoomNumber',IntegerType::class,array(
                'required'=>false
            ))
            ->add('bathRoomNumber',IntegerType::class,array(
                'required'=>false
            ))
            ->add('kitchenNumber',IntegerType::class,array(
                'required'=>false
            ))
            ->add('garage',CheckboxType::class,array(
                'required'=>false
            ))
            ->add('parking', CheckboxType::class, array(
                'required'=> false,
            ))
            ->add('activate', CheckboxType::class, array(
                'required'=> false,
            ))
            ->add('image', ImageType::class, array(
                'required'=> is_null($builder->getData()->getImage()),
                'label'=> 'Image'
            ))
            ->add('ville', EntityType::class, array(
                'class'=> Ville::class,
                'choice_label'=> 'name',
                'placeholder'=> 'Choisr ville'
            ))
            ->add('region', EntityType::class, array(
                'class'=> Region::class,
                'choice_label'=>'name',
                'placeholder'=>'choisir region'
            ) )
            ->add('category', EntityType::class, array(
                'class'=> Category::class,
                'choice_label'=>'name',
                'placeholder'=>'choisir category'
            ))
            ->add('operation', ChoiceType::class, array(
                'choices'=> array(
                    'Location'=> 'Location',
                    'Vente'=> 'Vente',
                ),
                'placeholder'=> 'Opération'
            ))
            ->add('photos', CollectionType::class, array(
                'entry_type'=> PhotoType::class,
                'entry_options' => array('label' => false),
                'allow_add' => true,
                'allow_delete'=> true,
                'by_reference' => false,
                'required'=> false,
                'label'=> false
            ))
        ;

        $formModifier = function (FormInterface $form, Ville $vile = null) {
            //si ville est null alors region = array vide
            // sion $resgions = array qui contient liste des resgion de cette ville
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
                // It's important here to fetch $event->getForm()->getData(), as
                // $event->getData() will get you the client data (that is, the ID)
                $ville = $event->getForm()->getData();

                // since we've added the listener to the child, we'll have to pass on
                // the parent to the callback functions!
                $formModifier($event->getForm()->getParent(), $ville);
            }
        );

        $builder->addEventListener(FormEvents::POST_SUBMIT, function (FormEvent $event) {
            $event->stopPropagation();
        }, 900); // Always set a higher priority than ValidationListener

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
        return 'appbundle_property';
    }


}
