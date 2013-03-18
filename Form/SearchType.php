<?php

namespace Orkestra\Bundle\TransactorIntelligenceBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class SearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('lowAmount', null, array('label' => 'Low Amount', 'required' => false))
            ->add('highAmount', null, array('label' => 'High Amount', 'required' => false))
            ->add('transactionType', 'enum', array('label' => 'Transaction Type', 'required' => false, 'enum' => 'Orkestra\Transactor\Entity\Transaction\TransactionType'))
            ->add('networkType', 'enum', array('label' => 'Network Type', 'required' => false, 'enum' => 'Orkestra\Transactor\Entity\Transaction\NetworkType'))
            ->add('resultStatus', 'enum', array('label' => 'Result Status', 'required' => false, 'enum' => 'Orkestra\Transactor\Entity\Result\ResultStatus'))
            ->add('dateStart', 'datetime', array('label' => 'Start Date', 'required' => false))
            ->add('dateEnd', 'datetime', array('label' => 'End Date', 'required' => false));
    }


    public function getName()
    {
        return 'search';
    }
}
