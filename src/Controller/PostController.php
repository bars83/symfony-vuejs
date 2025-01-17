<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Post;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\Annotations as Rest;
use Psr\Log\LoggerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * @Rest\Route("/api")
 * @IsGranted("IS_AUTHENTICATED_FULLY")
 */
final class PostController extends AbstractController
{
    /** @var EntityManagerInterface */
    private $em;

    /** @var SerializerInterface */
    private $serializer;

    public function __construct(EntityManagerInterface $em, SerializerInterface $serializer)
    {
        $this->em = $em;
        $this->serializer = $serializer;
    }

    /**
     * @throws BadRequestHttpException
     *
     * @Rest\Post("/posts", name="createPost")
     * @IsGranted("ROLE_FOO")
     */
    public function createAction(Request $request, LoggerInterface $logger): JsonResponse
    {
        $logger->info('Call to post controller create action');
        $message = $request->request->get('message');
        if (empty($message)) {
            throw new BadRequestHttpException('message cannot be empty');
        }
        $post = new Post();
        $post->setMessage($message);
        $this->em->persist($post);
        $this->em->flush();
        $data = $this->serializer->serialize($post, JsonEncoder::FORMAT);

        return new JsonResponse($data, Response::HTTP_CREATED, [], true);
    }

    /**
     * @Rest\Get("/posts", name="findAllPosts")
     */
    public function findAllAction(LoggerInterface $logger): JsonResponse
    {
        $logger->info('Call to post controller create findAll action');
        $posts = $this->em->getRepository(Post::class)->findBy([], ['id' => 'DESC']);
        $result = [
            'posts' => $posts,
            'backend_host' => $_SERVER['HOSTNAME'],
            'web_host' => $_SERVER['web_hostname'],
            'backend_build_time' => $_SERVER['BUILD_TIME_ENV']
        ];
        $data = $this->serializer->serialize($result, JsonEncoder::FORMAT);

        return new JsonResponse($data, Response::HTTP_OK, [], true);
    }
}
