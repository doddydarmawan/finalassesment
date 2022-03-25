<?php

declare(strict_types=1);

namespace Icube\OkrDivisiCustomSyaiful\Helper;

use Magento\Framework\Api\SortOrder;
use Magento\Framework\Api\SortOrderBuilder;
use Magento\Framework\Api\FilterBuilder;
use Magento\Framework\Api\Search\FilterGroupBuilder;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SearchCriteriaFactory;

/**
 * SearchCriteriaHelper
 */
class SearchCriteriaHelper
{
    /**
     * @var FilterBuilder
     */
    private $filterBuilder;

    /**
     * @var FilterGroupBuilder
     */
    private $filterGroupBuilder;

    /**
     * @var SearchCriteriaFactory
     */
    private $searchCriteriaFactory;

    /**
     * @var SortOrderBuilder
     */
    private $sortOrderBuilder;

    /**
     * GetTrainerById constructor.
     *
     * @param FilterBuilder $filterBuilder
     * @param FilterGroupBuilder $filterGroupBuilder
     * @param SearchCriteriaFactory $searchCriteriaFactory
     * @param SortOrderBuilder $sortOrderBuilder
     */
    public function __construct(
        FilterBuilder $filterBuilder,
        FilterGroupBuilder $filterGroupBuilder,
        SearchCriteriaFactory $searchCriteriaFactory,
        SortOrderBuilder $sortOrderBuilder
    ) {
        $this->filterBuilder = $filterBuilder;
        $this->filterGroupBuilder = $filterGroupBuilder;
        $this->searchCriteriaFactory = $searchCriteriaFactory;
        $this->sortOrderBuilder = $sortOrderBuilder;
    }

    /**
     * build
     *
     * @param array $args
     * return SearchCriteriaInterface
     */
    public function build(array $args) : SearchCriteriaInterface
    {
        $searchCriteria = $this->searchCriteriaFactory->create();

        if (trim(@$args['search']) != '') {
            $this->addFilter($searchCriteria, "nama", "%".$args['search']."%", "like");
        }

        $filters = is_array(@$args['filter']) ? $args['filter'] : [];
        foreach ($filters as $fieldName => $filter) {
            foreach ($filter as $conditionType => $value) {
                $this->addFilter($searchCriteria, $fieldName, $value, $conditionType);
            }
        }

        $sorts  = is_array(@$args['sort']) ? $args['sort'] : [];
        foreach ($sorts as $sortField => $sortDirection) {
            $this->addSortOrder($searchCriteria, $sortField, $sortDirection);
        }

        $searchCriteria->setPageSize(@$args['pageSize']);
        $searchCriteria->setCurrentPage(@$args['currentPage']);

        return $searchCriteria;
    }

    /**
     * Add filter to search criteria
     *
     * @param SearchCriteriaInterface $searchCriteria
     * @param string $field
     * @param mixed $value
     */
    private function addFilter(
        SearchCriteriaInterface $searchCriteria,
        string $field,
        $value,
        $conditionType
    ): void {
        $filter = $this->filterBuilder
            ->setField($field)
            ->setValue($value)
            ->setConditionType($conditionType)
            ->create();
        $this->filterGroupBuilder->addFilter($filter);
        $filterGroups = $searchCriteria->getFilterGroups();
        $filterGroups[] = $this->filterGroupBuilder->create();
        $searchCriteria->setFilterGroups($filterGroups);
    }

    /**
     * Sort by id ASC by default
     *
     * @param SearchCriteriaInterface $searchCriteria
     */
    private function addSortOrder(
        SearchCriteriaInterface $searchCriteria,
        String $sortField,
        $sortDirection
    ): void {
        $defaultSortOrder = $this->sortOrderBuilder
            ->setField($sortField)
            ->setDirection($sortDirection)
            ->create();

        $searchCriteria->setSortOrders([$defaultSortOrder]);
    }
}