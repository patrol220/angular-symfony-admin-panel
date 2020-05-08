<?php

namespace App\Repository;

use App\Dto\Request\SortDto;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;

abstract class AbstractRepository extends ServiceEntityRepository
{
    protected function addFilter(QueryBuilder $queryBuilder, string $name, $value, string $alias = null)
    {
        if ($value === null || $value === '' || $value === [] || $name === null) {
            return;
        }

        if ($alias === null) {
            $alias = $queryBuilder->getRootAliases()[0];
        }

        $queryBuilder->andWhere(sprintf('%s.%s = :%s', $alias, $name, $name));
        $queryBuilder->setParameter($name, $value);
    }

    protected function addLikeFilter(QueryBuilder $queryBuilder, string $name, $value, string $alias = null)
    {
        if ($value === null || $value === '' || $value === [] || $name === null) {
            return;
        }

        if ($alias === null) {
            $alias = $queryBuilder->getRootAliases()[0];
        }

        $queryBuilder->andWhere(sprintf('LOWER(%s.%s) LIKE :%s', $alias, $name, $name));
        $queryBuilder->setParameter($name, '%' . strtolower($value) . '%');
    }

    protected function addSort(QueryBuilder $queryBuilder, SortDto $sortDto, string $alias = null)
    {
        if ($sortDto === null) {
            return;
        }

        if ($alias === null) {
            $alias = $queryBuilder->getRootAliases()[0];
        }

        $queryBuilder->addOrderBy(sprintf('%s.%s', $alias, $sortDto->getSortField()), $sortDto->getSortDirection());
    }
}
