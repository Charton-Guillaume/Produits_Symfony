<?php

namespace App\Repository;

use App\Entity\Produit;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Produit|null find($id, $lockMode = null, $lockVersion = null)
 * @method Produit|null findOneBy(array $criteria, array $orderBy = null)
 * @method Produit[]    findAll()
 * @method Produit[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProduitRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Produit::class);
    }

    // /**
    //  * @return Produit[] Returns an array of Produit objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Produit
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
    public function findCriteresRecherche(\App\Donnees\DonneesRecherche $donnees)
    {
        $requete = $this->createQueryBuilder('p')
            ->select('c', 'p')
            ->join('p.categories', 'c');
        // DEFINITION DES CRITERES DE RECHERCHEreturn $requete->getQuery()->getResult();
        if (!empty($donnees->motCle)) {
            $requete = $requete
                ->andWhere('p.nomLIKE :motCle')
                ->setParameter('motCle', "%{$donnees->motCLe}%");
        }
        if (!empty($donnees->prixMin)) {
            $requete = $requete
                ->andWhere('p.prix>= :min')
                ->setParameter('min', $donnees->prixMin);
        }
        if (!empty($donnees->prixMax)) {
            $requete = $requete
                ->andWhere('p.prix<= :max')
                ->setParameter('max', $donnees->prixMax);
        }
        if (!empty($donnees->promo)) {
            $requete= $requete
                ->andWhere('p.promo= 1');
        }
        if (!empty($donnees->categories)) {
            $requete= $requete
                ->andWhere('c.id IN (:categories)')
                ->setParameter('categories', $donnees->categories);
        }

        return $requete->getQuery()->getResult();
    }
}
