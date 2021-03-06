<?php

namespace App\Controller;

use App\Entity\Book;
use App\Repository\BookRepository;
use Doctrine\ORM\EntityManagerInterface;
use JMS\Serializer\SerializerBuilder;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BooksController extends AbstractController
{
    /**
     * @var BookRepository
     */
    private $repo;

    /**
     * BooksController constructor.
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->repo = $em->getRepository(Book::class);
    }

    /**
     * @Route("/books", name="list-books", methods={"GET"})
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function listBooks()
    {
        $books = $this->repo->findAll();
        $serializer = SerializerBuilder::create()->build();
        return new Response($serializer->serialize($books, 'json'));
    }

    /**
     * @Route("/books", name="add-book", methods={"POST"})
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function addBook(Request $request)
    {
        $book = [];
        if ($content = $request->getContent()) {
            $book = \json_decode($content, true);
        }

        $id = $this->repo->addBook($book);

        return $this->json([
            'id' => $id,
        ]);
    }

    /**
     * @Route("/books/{id}", name="delete-book", methods={"DELETE"})
     * @param int $id
     * @return JsonResponse
     */
    public function deleteBook(int $id)
    {
        $this->repo->deleteBook($id);

        return $this->json([
            'id' => $id,
        ]);
    }

    /**
     * @Route("/books/{id}", name="update-book", methods={"PUT"})
     * @param int $id
     * @param Request $request
     * @return JsonResponse
     */
    public function updateBook(int $id, Request $request)
    {
        $book = [];
        if ($content = $request->getContent()) {
            $book = \json_decode($content, true);
        }

        $this->repo->updateBook($id, $book);

        return $this->json([
            'id' => $id,
        ]);
    }

    /**
     * @Route("/books/{bookId}/readers/{readerId}", name="borrow-book", methods={"PUT"})
     * @param int $bookId
     * @param int $readerId
     * @return JsonResponse
     */
    public function borrowBook(int $bookId, int $readerId)
    {
        $this->repo->borrowBook($bookId, $readerId);

        return $this->json([]);
    }

    /**
     * @Route("/books/{bookId}/return", name="return-book", methods={"PUT"})
     * @param int $bookId
     * @return JsonResponse
     */
    public function returnBook(int $bookId)
    {
        $this->repo->returnBook($bookId);

        return $this->json([]);
    }
}
