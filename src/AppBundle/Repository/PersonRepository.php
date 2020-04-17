<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Person;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityRepository;

class PersonRepository extends EntityRepository
{
    /**
     * @return Person[]|ArrayCollection
     */
    public function findThoseWithBirthdayToday(): ArrayCollection
    {
        $qb = $this->createQueryBuilder('p');

        $from = new \DateTime();
        $from->setTime(0, 0, 0);
        $until = new \DateTime();
        $until->setTime(23, 59, 59);

        $results = $qb
            ->where($qb->expr()->andX(
                $qb->expr()->gte('p.birthDate', ':from'),
                $qb->expr()->lte('p.birthDate', ':until')
            ))
            ->setParameter('from', $from)
            ->setParameter('until', $until)
            ->getQuery()
            ->execute();

        return new ArrayCollection($results);
    }
}
