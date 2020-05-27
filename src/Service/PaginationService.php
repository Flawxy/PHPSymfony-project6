<?php

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;

class PaginationService
{
    private ?string $entityClass;
    private ?string $propertyName = null;
    private $propertyValue = null;
    private string $propertyToOrderBy;
    private string $orderBy = 'DESC';
    private int $limit = 5;
    private int $currentPage = 1;
    private EntityManagerInterface $manager;

    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager = $manager;
    }

    public function getPages()
    {
        // Retrieves the amount of entries in the DB
        $repo = $this->manager->getRepository($this->entityClass);
        $total = count($repo->findAll());

        // Divides, rounds and returns
        return ceil($total / $this->limit);
    }

    public function getTotalData()
    {
        $repo = $this->manager->getRepository($this->entityClass);
        return count($repo->findAll());
    }

    public function getData()
    {
        // Calculates the offset
        $offset = $this->limit * ($this->currentPage - 1);

        // Finds the correct repository
        $repo = $this->manager->getRepository($this->entityClass);

        // Returns the sorted data
        if ($this->propertyName !== null AND $this->propertyValue !== NULL) {
            return $repo->findBy([$this->propertyName => $this->propertyValue], [$this->propertyToOrderBy => $this->orderBy], $this->limit, $offset);
        }
        return $repo->findBy([], [$this->propertyToOrderBy => $this->orderBy], $this->limit, $offset);
    }

    /**
     * @return string|null
     */
    public function getPropertyName(): ?string
    {
        return $this->propertyName;
    }

    /**
     * @param string|null $propertyName
     * @return PaginationService
     */
    public function setPropertyName($propertyName): PaginationService
    {
        $this->propertyName = $propertyName;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getPropertyValue()
    {
        return $this->propertyValue;
    }

    /**
     * @param string|null $propertyValue
     * @return PaginationService
     */
    public function setPropertyValue($propertyValue): PaginationService
    {
        $this->propertyValue = $propertyValue;
        return $this;
    }

    /**
     * @return string
     */
    public function getPropertyToOrderBy(): string
    {
        return $this->propertyToOrderBy;
    }

    /**
     * @param string $propertyToOrderBy
     * @return PaginationService
     */
    public function setPropertyToOrderBy(string $propertyToOrderBy): PaginationService
    {
        $this->propertyToOrderBy = $propertyToOrderBy;
        return $this;
    }

    /**
     * @return string
     */
    public function getOrderBy(): string
    {
        return $this->orderBy;
    }

    /**
     * @param string $orderBy
     * @return PaginationService
     */
    public function setOrderBy(string $orderBy): PaginationService
    {
        $this->orderBy = $orderBy;
        return $this;
    }

    public function setEntityClass(string $entityClass): PaginationService
    {
        $this->entityClass = $entityClass;

        return $this;
    }

    public function getEntityClass(): string
    {
        return $this->entityClass;
    }

    public function setLimit(int $limit): PaginationService
    {
        $this->limit = $limit;

        return $this;
    }

    public function getLimit(): int
    {
        return $this->limit;
    }

    public function setCurrentPage(int $currentPage): PaginationService
    {
        $this->currentPage = $currentPage;

        return $this;
    }

    public function getCurrentPage(): int
    {
        return $this->currentPage;
    }

}