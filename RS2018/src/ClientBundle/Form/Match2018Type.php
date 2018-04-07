<?php

namespace ClientBundle\Form;

use ClientBundle\Entity\Match2018;
use ClientBundle\Repository\Match2018Repository;
use ClientBundle\Repository\EquipeRepository;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class Match2018Type extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('date')
            ->add('time',TimeType::class)
            ->add('etat',ChoiceType::class,array(
                'choices'=>array(
                    'Debut'=>'Debut',
                    'Encours'=>'Encours',
                    'Termine'=>'Termine'
                ),
            ))
            ->add('nombreSpectateur')
            ->add('Save',SubmitType::class);
            $builder->addEventListener(
                FormEvents::POST_SET_DATA,
                function (FormEvent $event){
                    $data=$event->getData();

                        $this->addEquipe1Field($event->getForm(),$data);
                        $this->addEquipe2Field($event->getForm(),$data);





                }
            );


    }

    private function addEquipe2Field(FormInterface $form,Match2018 $equipe){
        $builder=$form->getConfig()->getFormFactory()->createNamedBuilder(
            'idEquipe2',
            EntityType::class,
            null,
            [
                'class'=>'ClientBundle\Entity\Equipe',
                'attr'=>array('readonly'=>true),
                'required'=>false,
                'auto_initialize'=>false,
                'choices' =>array($equipe->getIdEquipe2())

            ]


        );
        $builder->addEventListener(
            FormEvents::POST_SUBMIT,
            function (FormEvent $event){

            }
        );
        $form->add($builder->getForm());

    }
    private function addEquipe1Field(FormInterface $form,Match2018 $equipe){
        $builder=$form->getConfig()->getFormFactory()->createNamedBuilder(
            'idEquipe1',
            EntityType::class,
            null,
            [
                'class'=>'ClientBundle\Entity\Equipe',
                'attr'=>array('readonly'=>true),
                'required'=>false,
                'auto_initialize'=>false,
                'choices' =>array($equipe->getIdEquipe1())
            ]


        );
        $builder->addEventListener(
            FormEvents::POST_SUBMIT,
            function (FormEvent $event){

            }
        );
        $form->add($builder->getForm());

    }
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'ClientBundle\Entity\Match2018'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'clientbundle_match2018';
    }


}
