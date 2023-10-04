<?php

namespace App\Repository;

use App\Entity\Log;
use DateTimeImmutable;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<Log>
 *
 * @method Log|null find($id, $lockMode = null, $lockVersion = null)
 * @method Log|null findOneBy(array $criteria, array $orderBy = null)
 * @method Log[]    findAll()
 * @method Log[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LogRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Log::class);
    }

    /**
     * @return Log[] Returns an array of Log objects
     */
    public function findAllLogs(): array
    {
        $sql = "SELECT l.* FROM log l";
        $entityManager = $this->getEntityManager();
        $connection = $entityManager->getConnection();
        $request = $connection->prepare($sql);
        $result = $request->execute();
        return $result->fetchAll();
    }

    /**
     * @return Log[] Returns an array of Log objects
     */
    public function findClickLogs(): array
    {
        $sql = "SELECT l.* FROM log l WHERE l.type = :type";
        $entityManager = $this->getEntityManager();
        $connection = $entityManager->getConnection();
        $request = $connection->prepare($sql);
        $result = $request->execute(['type' => 'click']);
        return $result->fetchAll();
    }

    /**
     * @return Log[] Returns an array of Log objects
     */
    public function findSeenLogs(): array
    {
        $sql = "SELECT l.* FROM log l WHERE l.type = :type";
        $entityManager = $this->getEntityManager();
        $connection = $entityManager->getConnection();
        $request = $connection->prepare($sql);
        $result = $request->execute(['type' => 'seen']);
        return $result->fetchAll();
    }

    /**
     * @param string $minDate
     * @param string $maxDate
     * @return Log[] Returns an array of Log objects
     */
    public function findDateLogs(string $min, string $max): array
    {
        $sql = "SELECT l.* FROM log l WHERE l.done_at BETWEEN :min AND :max";
        $entityManager = $this->getEntityManager();
        $connection = $entityManager->getConnection();
        $request = $connection->prepare($sql);
        $result = $request->execute(['min' => $min, 'max' => $max]);
        return $result->fetchAll();
    }

    /**
     * @param int $id
     * @return Log[] Returns an array of Log objects
     */
    public function findByIdLogs(int $id): array
    {
        $sql = "SELECT l.* FROM log l WHERE l.ad_id = :id";
        $entityManager = $this->getEntityManager();
        $connection = $entityManager->getConnection();
        $request = $connection->prepare($sql);
        $result = $request->execute(['id' => $id]);
        return $result->fetchAll();
    }

    /**
     * @param int $id
     * @return Log[] Returns an array of Log objects
     */
    public function findByIdClickLogs(int $id): array
    {
        $sql = "SELECT l.* FROM log l WHERE l.type = :type AND l.ad_id = :id";
        $entityManager = $this->getEntityManager();
        $connection = $entityManager->getConnection();
        $request = $connection->prepare($sql);
        $result = $request->execute(['type' => 'click', 'id' => $id]);
        return $result->fetchAll();
    }

    /**
     * @param int $id
     * @return Log[] Returns an array of Log objects
     */
    public function findByIdSeenLogs(int $id): array
    {
        $sql = "SELECT l.* FROM log l WHERE l.type = :type AND l.ad_id = :id";
        $entityManager = $this->getEntityManager();
        $connection = $entityManager->getConnection();
        $request = $connection->prepare($sql);
        $result = $request->execute(['type' => 'seen', 'id' => $id]);
        return $result->fetchAll();
    }

    /**
     * @param int $id
     * @param string $minDate
     * @param string $maxDate
     * @return Log[] Returns an array of Log objects
     */
    public function findByIdDateLogs(string $minDate, string $maxDate, int $id): array
    {
        $sql = "SELECT l.* FROM log l WHERE l.done_at BETWEEN :min AND :max AND l.ad_id = :id ORDER BY l.done_at";
        $entityManager = $this->getEntityManager();
        $connection = $entityManager->getConnection();
        $request = $connection->prepare($sql);
        $result = $request->execute(['min' => $minDate, 'max' => $maxDate, 'id' => $id]);
        // dd($result);
        return $result->fetchAll();
    }
}
