<?php

namespace App\Normalizer;

use Normalizer;
use App\Entity\Recipe;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class PaginationNormalizer implements NormalizerInterface
{

    public function __construct(
        #[Autowire(service: 'serializer.normalizer.object')]
        private readonly NormalizerInterface $normalizer)
    {
        
    }

    public function normalize(mixed $object, ?string $format = null, array $context = []):bool|string|int|float|null|\ArrayObject|array 
    {
        // TODO : IMPLEMENT normalize() method.
        if(!($object instanceof PaginationInterface)){
            throw new \RuntimeException();
        }

        //jexplique la normalization a faire
        return [
            'items' => array_map(fn (Recipe $recipe) => $this->normalizer->normalize($recipe, $format, $context), $object->getItems()),
            'total' => $object->getTotalItemCount(),
            'page' => $object->getCurrentPageNumber(),
                'lastPage' => ceil($object->getTotalItemCount() / $object->getItemNumberPerPage())
        ];
    }

    public function supportsNormalization(mixed $data, ?string $format = null, array $context = []): bool
    {
        // TODO : IMPLEMENT supportsNormalization() method.
        return $data instanceof PaginationInterface;
    }

    public function getSupportedTypes(?string $format): array
    {
        // TODO : IMPLEMENT getSupportedTypes() method.
        return [
            PaginationInterface::class => true
        ];
        
    }
}