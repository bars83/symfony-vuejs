<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\User;
use Psr\Log\LoggerInterface;
use RuntimeException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * @Route("/api")
 */
final class SecurityController extends AbstractController
{
    /** @var SerializerInterface */
    private $serializer;

    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    /**
     * @Route("/security/login", name="login")
     */
    public function loginAction(LoggerInterface $logger): JsonResponse
    {
        $logger->info('Call to security controller create login action');
        /** @var User $user */
        $user = $this->getUser();
        $userClone = clone $user;
        $userClone->setPassword('');
        $data = $this->serializer->serialize($userClone, JsonEncoder::FORMAT);

        return new JsonResponse($data, Response::HTTP_OK, [], true);
    }

    /**
     * @throws RuntimeException
     *
     * @Route("/security/logout", name="logout")
     */
    public function logoutAction(LoggerInterface $logger): void
    {
        $logger->info('Call to security controller create logout action');
        throw new RuntimeException('This should not be reached!');
    }
}
