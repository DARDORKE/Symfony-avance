<?php

namespace App\Repository;

use App\Entity\Employee;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Employee>
 *
 * @method Employee|null find($id, $lockMode = null, $lockVersion = null)
 * @method Employee|null findOneBy(array $criteria, array $orderBy = null)
 * @method Employee[]    findAll()
 * @method Employee[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EmployeeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Employee::class);
    }

    public function add(Employee $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Employee $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @return Employee[] Returns an array of Employee objects
     */
    public function findAllWithQB(): array
    {
        return $this->createQueryBuilder('e')
            ->getQuery()
            ->getResult()
        ;
    }

    public function findOneByUsername($value): ?Employee
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.username = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

    public function findAllWithDQL()
    {
    return $this->getEntityManager()
        ->createQuery('
        SELECT e
        FROM App\Entity\Employee e
        ')
        ->getResult();
    }

    public function findOneByUsernameWithDQL(string $value): ?Employee
    {
        return $this->getEntityManager()
            ->createQuery('
             SELECT e
             FROM App\Entity\Employee e
             WHERE e.username = :username
            ')
            ->setParameter('username', $value)
            ->getOneOrNullResult();
    }
}
