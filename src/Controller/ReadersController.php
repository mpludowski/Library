<?php namespace App\Controller;

use App\Entity\Reader;
use App\Repository\ReaderRepository;
use Doctrine\ORM\EntityManagerInterface;
use JMS\Serializer\SerializerBuilder;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ReadersController extends AbstractController
{
    /**
     * @var ReaderRepository
     */
    private $repo;

    /**
     * ReadersController constructor.
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->repo = $em->getRepository(Reader::class);
    }

    /**
     * @Route("/readers", name="list-readers", methods={"GET"})
     * @return Response
     */
    public function listReaders()
    {
        $readers = $this->repo->findAll();
        $serializer = SerializerBuilder::create()->build();
        return new Response($serializer->serialize($readers, 'json'));
    }

    /**
     * @Route("/readers", name="add-reader", methods={"POST"})
     * @param Request $request
     * @return JsonResponse
     */
    public function addReader(Request $request)
    {
        $reader = [];
        if ($content = $request->getContent()) {
            $reader = \json_decode($content, true);
        }

        $id = $this->repo->addReader($reader);

        return $this->json([
            'id' => $id,
        ]);
    }

    /**
     * @Route("/readers/{id}", name="delete-reader", methods={"DELETE"})
     * @param int $id
     * @return JsonResponse
     */
    public function deleteReader(int $id)
    {
        $this->repo->deleteReader($id);

        return $this->json([
            'id' => $id,
        ]);
    }

    /**
     * @Route("/readers/{id}", name="update-reader", methods={"PUT"})
     * @param int $id
     * @param Request $request
     * @return JsonResponse
     */
    public function updateReader(int $id, Request $request)
    {
        $reader = [];
        if ($content = $request->getContent()) {
            $reader = \json_decode($content, true);
        }

        $this->repo->updateReader($id, $reader);

        return $this->json([
            'id' => $id,
        ]);
    }
}
