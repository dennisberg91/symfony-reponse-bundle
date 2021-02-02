<?php declare(strict_types=1);

namespace Learning\LearningBundle\Controller;

use JMS\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController as BaseController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

/**
 * Abstract controller providing generic functionality.
 */
abstract class AbstractController extends BaseController
{
    protected SerializerInterface $serializer;

    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    /**
     * Converts the given array or object (entity) to a JsonResponse.
     *
     * @param array|object $content
     * @param int $status
     *
     * @return JsonResponse
     */
    protected function jsonResponse(
        $content,
        int $status = Response::HTTP_OK
    ): JsonResponse {
        if (!is_array($content) && !is_object($content)) {
            throw new \InvalidArgumentException(
                sprintf(
                    '%s expects $content to be either an array or an object; "%s" given.',
                    __METHOD__,
                    gettype($content)
                )
            );
        }

        $json = $this->serializer->serialize($content, 'json');

        return JsonResponse::fromJsonString($json, $status);
    }
}
