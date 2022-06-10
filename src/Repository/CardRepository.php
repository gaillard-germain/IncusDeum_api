<?php

namespace App\Repository;

use App\Entity\Card;
use App\Entity\Media;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Card>
 *
 * @method Card|null find($id, $lockMode = null, $lockVersion = null)
 * @method Card|null findOneBy(array $criteria, array $orderBy = null)
 * @method Card[]    findAll()
 * @method Card[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CardRepository extends ServiceEntityRepository
{
    private $objectPerPage;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Card::class);
        $this->objectPerPage = 10;
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Card $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function remove(Card $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
    * @return Card[] Returns an array of Card objects
    */
    public function findPage(int $page = 1)
    {
        return $this->createQueryBuilder('card')
            ->leftjoin('card.category', 'category')
            ->leftjoin('card.fx', 'fx')
            ->addSelect('category')
            ->addSelect('fx')
            ->orderBy('card.name', 'ASC')
            ->setFirstResult(($page - 1 )* $this->objectPerPage)
            ->setMaxResults($this->objectPerPage)
            ->getQuery()
            ->getResult()
        ;
    }

    /**
    * @return int Returns the number of pages
    */
    public function countPage()
    {
      $totalCards = $this->createQueryBuilder('card')
      ->select('count(card.id)')
      ->getQuery()
      ->getSingleScalarResult();

      return intval(ceil($totalCards / $this->objectPerPage));
    }

    /**
    * @return int Returns the number of cards with image given
    */
    public function countCardImage(Media $media)
    {
      $nbrCards = $this->createQueryBuilder('card')
      ->select('count(card.id)')
      ->where('card.frontImage = :media')
      ->setParameter('media', $media)
      ->getQuery()
      ->getSingleScalarResult();

      return $nbrCards;
    }

    // /**
    //  * @return Card[] Returns an array of Card objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Card
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
