<?php

namespace App\Repository;

use App\Entity\Book;
use App\Entity\Reader;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use JMS\Serializer\Annotation\Type as JMS;

/**
 * @method Book|null find($id, $lockMode = null, $lockVersion = null)
 * @method Book|null findOneBy(array $criteria, array $orderBy = null)
 * @method Book[]    findAll()
 * @method Book[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BookRepository extends ServiceEntityRepository
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * BookRepository constructor.
     * @param ManagerRegistry $registry
     * @param EntityManagerInterface $em
     */
    public function __construct(ManagerRegistry $registry, EntityManagerInterface $em)
    {
        parent::__construct($registry, Book::class);
        $this->em = $em;
    }

    /**
     * @param array $data
     * @return int
     */
    public function addBook(array $data): int
    {
        $book = new Book();
        $book->setName($data['name'] ?? '');
        $book->setAuthor($data['author'] ?? '');
        $book->setToSell($data['to_sell'] ?? false);

        $this->em->persist($book);
        $this->em->flush();

        return $book->getId();
    }

    /**
     * @param int $id
     */
    public function deleteBook(int $id): void
    {
        $book = $this->find($id);
        $this->em->remove($book);
        $this->em->flush();
    }

    /**
     * @param int $id
     * @param array $data
     */
    public function updateBook(int $id, array $data)
    {
        $book = $this->find($id);
        isset($data['name']) ? $book->setName($data['name']) : null;
        isset($data['author']) ? $book->setAuthor($data['author']) : null;
        isset($data['to_sell']) ? $book->setToSell($data['to_sell']) : null;

        $this->em->persist($book);
        $this->em->flush();
    }

    public function borrowBook(int $bookId, int $readerId)
    {
        $book = $this->find($bookId);
        $reader = $this->em->getRepository(Reader::class)->find($readerId);

        $book->setBorrowedTo($reader);

        $this->em->persist($book);
        $this->em->flush();
    }

    public function returnBook(int $bookId)
    {
        $book = $this->find($bookId);
        $book->setBorrowedTo(null);

        $this->em->persist($book);
        $this->em->flush();
    }
}
