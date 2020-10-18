<?php

namespace App\Repository;

use App\Entity\Reader;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Reader|null find($id, $lockMode = null, $lockVersion = null)
 * @method Reader|null findOneBy(array $criteria, array $orderBy = null)
 * @method Reader[]    findAll()
 * @method Reader[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ReaderRepository extends ServiceEntityRepository
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * ReaderRepository constructor.
     * @param ManagerRegistry $registry
     * @param EntityManagerInterface $em
     */
    public function __construct(ManagerRegistry $registry, EntityManagerInterface $em)
    {
        parent::__construct($registry, Reader::class);
        $this->em = $em;
    }

    /**
     * @param array $data
     */
    public function addReader(array $data)
    {
        $reader = new Reader();
        $reader->setName($data['name'] ?? '');
        $reader->setSurname($data['surname'] ?? '');


        $this->em->persist($reader);
        $this->em->flush();

        return $reader->getId();
    }

    /**
     * @param int $id
     */
    public function deleteReader(int $id)
    {
        $reader = $this->find($id);
        $this->em->remove($reader);
        $this->em->flush();
    }

    /**
     * @param int $id
     * @param array $data
     */
    public function updateReader(int $id, array $data)
    {
        $reader = $this->find($id);
        isset($data['name']) ? $reader->setName($data['name']) : null;
        isset($data['surname']) ? $reader->setSurname($data['surname']) : null;

        $this->em->persist($reader);
        $this->em->flush();
    }
}
