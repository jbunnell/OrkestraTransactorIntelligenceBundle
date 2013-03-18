<?php

namespace Orkestra\Bundle\TransactorIntelligenceBundle\Controller;

use Orkestra\Bundle\TransactorIntelligenceBundle\Form\SearchType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Searches transactions
 *
 * @Route("/transactions/search")
 */
class SearchController extends Controller
{
    /**
     * Runs Search Query.
     *
     * @Route("/results", name="transaction_search")
     * @Template()
     */
    public function searchAction(Request $request)
    {
        $form = $this->createForm(new SearchType());
        $form->bind($request);

        /** @var \Doctrine\ORM\EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        if ($form->isValid()) {
            $data = $form->getData();

            $qb = $em->createQueryBuilder()
                ->select('t')
                ->from('Orkestra\Transactor\Entity\Transaction', 't')
                ->leftJoin('t.result', 'r' )
                ->where('t.active = true');

            if ($data['lowAmount']) {
                $qb->andWhere('t.amount >= :lowAmount')
                    ->setParameter('lowAmount', $data['lowAmount']);
            }
            if ($data['highAmount']) {
                $qb->andWhere('t.amount <= :highAmount')
                    ->setParameter('highAmount', $data['highAmount']);
            }
            if ($data['dateStart']) {
                $qb->andWhere('r.dateTransacted >= :dateStart')
                    ->setParameter('dateStart', $data['dateStart']);
            }
            if ($data['dateEnd']) {
                $qb->andWhere('r.dateTransacted >= :dateEnd')
                    ->setParameter('dateEnd', $data['dateEnd']);
            }
            if ($data['transactionType']) {
                $qb->andWhere('t.type = :transactionType')
                    ->setParameter('transactionType', $data['transactionType']);
            }
            if ($data['networkType']) {
                $qb->andWhere('t.network = :networkType')
                    ->setParameter('networkType', $data['networkType']);
            }
            if ($data['resultStatus']) {
                $qb->andWhere('t.status = :resultStatus')
                    ->setParameter('resultStatus', $data['resultStatus']);
            }


            $transactions = $qb->getQuery()
                ->getResult();

        }else {
            $transactions = array();
        }


        return array(
            'transactions' => $transactions,
            'form' => $form->createView()
        );
    }
}
