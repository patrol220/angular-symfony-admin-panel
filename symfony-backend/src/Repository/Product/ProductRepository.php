<?php

namespace App\Repository\Product;

use App\Dto\Request\CursorDto;
use App\Dto\Request\SortDto;
use App\Entity\Product\Product;
use App\Repository\AbstractRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Product|null find($id, $lockMode = null, $lockVersion = null)
 * @method Product|null findOneBy(array $criteria, array $orderBy = null)
 * @method Product[]    findAll()
 * @method Product[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductRepository extends AbstractRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

    /**
     * @param CursorDto $cursor
     * @return Product[]
     */
    public function findWithCursor(CursorDto $cursor, SortDto $sortDto): array
    {
        $queryBuilder = $this->createQueryBuilder('p');

        $this->addSort($queryBuilder, $sortDto);

        if ($sortDto !== null) {
            if ($cursor->getCursor() !== null) {
                $cursorArray = explode(',', $cursor->getCursor());
                if (count($cursorArray) === 1) {
                    $queryBuilder->andWhere(
                        sprintf(
                            'p.%s %s :cursor',
                            $sortDto->getSortField(),
                            $sortDto->getSortDirection() === SortDto::SORT_DIR_ASC ? '>' : '<'
                        )
                    )
                        ->setParameter('cursor', $cursor->getCursor());
                }

                if (count($cursorArray) === 2) {
                    $queryBuilder
                        ->andWhere(
                            sprintf(
                                'p.%s %s :cursor_field',
                                $sortDto->getSortField(),
                                $sortDto->getSortDirection() === SortDto::SORT_DIR_ASC ? '>=' : '<='
                            )
                        )
                        ->andWhere(
                            sprintf(
                                'p.id %s :cursor_id',
                                $sortDto->getSortDirection() === SortDto::SORT_DIR_ASC ? '>' : '<'
                            )
                        )
                        ->setParameter('cursor_field', $cursorArray[0])
                        ->setParameter('cursor_id', $cursorArray[1]);
                }
            }
        } else {
            $queryBuilder->andWhere('p.id > :cursor');
        }

        return $queryBuilder
            ->setMaxResults($cursor->getLimit())
            ->getQuery()
            ->getResult();
    }

    public function getSortedProductsQueryBuilder(SortDto $sortDto)
    {
        $queryBuilder = $this->createQueryBuilder('p');

        $this->addSort($queryBuilder, $sortDto);

        return $queryBuilder;
    }

    public function getProductsCount() {
        $queryBuilder = $this->createQueryBuilder('ps');

        return $queryBuilder->select('COUNT(ps) as products_count')
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function getNewestProducts(int $count) {
        $queryBuilder = $this->createQueryBuilder('p');

        return $queryBuilder
            ->addOrderBy('p.created', 'desc')
            ->addOrderBy('p.id', 'desc')
            ->setMaxResults($count)
            ->getQuery()
            ->getResult();
    }
}
