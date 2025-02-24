<?php

namespace App\Repository;

use App\Entity\Respuestas;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Respuestas>
 */
/**
 * @method Respuestas|null find($id, $lockMode = null, $lockVersion = null)
 * @method Respuestas|null findOneBy(array $criteria, array $orderBy = null)
 * @method Respuestas[]    findAll()
 * @method Respuestas[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RespuestasRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Respuestas::class);
    }


    public function resultadoEncuestas(): array
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = 'SELECT
        p.titulo AS "Titulo",
        AVG(r.valoracion) AS "Promedio",
        r.comentario AS "Comentario"

        FROM respuestas AS r
        LEFT JOIN preguntas AS p ON r.pregunta_id=p.id
        GROUP BY r.pregunta_id';

        $resultSet = $conn->executeQuery($sql);
        return $resultSet->fetchAll();

    }


//    /**
//     * @return Respuestas[] Returns an array of Respuestas objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('r.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Respuestas
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
