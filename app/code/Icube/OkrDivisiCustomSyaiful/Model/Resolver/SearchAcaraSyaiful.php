<?php

declare(strict_types=1);

namespace Icube\OkrDivisiCustomSyaiful\Model\Resolver;

use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Exception\GraphQlInputException;
use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;
use Icube\OkrDivisiCustomSyaiful\Model\AcaraSyaifulV2;
use Icube\OkrDivisiCustomSyaiful\Helper\SearchCriteriaHelper;
use Icube\OkrDivisiCustomSyaiful\Repository\PesertaSyaifulRepository;

/**
 * SearchAcaraSyaiful
 */
class SearchAcaraSyaiful implements ResolverInterface
{
    /**
     * @var AcaraSyaifulV2
     */
    private $acaraSyaifulV2;

    /**
     * @var SearchCriteriaHelper
     */
    private $searchCriteriaHelper;

    /**
     * @var PesertaSyaifulRepository
     */
    private $pesertaSyaifulRepository;

    /**
     * SearchTrainer constructor.
     *
     * @param AcaraSyaifulV2 $acaraSyaifulV2
     * @param SearchCriteriaHelper $searchCriteriaHelper
     * @param PesertaSyaifulRepository $pesertaSyaifulRepository
     */
    public function __construct(
        AcaraSyaifulV2 $acaraSyaifulV2,
        SearchCriteriaHelper $searchCriteriaHelper,
        PesertaSyaifulRepository $pesertaSyaifulRepository
    ) {
        $this->acaraSyaifulV2 = $acaraSyaifulV2;
        $this->searchCriteriaHelper = $searchCriteriaHelper;
        $this->pesertaSyaifulRepository = $pesertaSyaifulRepository;
    }

    /**
     * @inheritdoc
     */
    public function resolve(
        Field $field,
        $context,
        ResolveInfo $info,
        array $value = null,
        array $args = null
    ) {
        // $customerId = $context->getUserId();
        // if (!$customerId && 0 === $customerId) {
        //     throw new GraphQlAuthorizationException(
        //         __('The current user cannot perform operations on searchTrainer')
        //     );
        // }

        if ($args['currentPage'] < 1) {
            throw new GraphQlInputException(__('currentPage value must be greater than 0.'));
        }

        if ($args['pageSize'] < 1) {
            throw new GraphQlInputException(__('pageSize value must be greater than 0.'));
        }

        $searchCriteria = $this->searchCriteriaHelper->build($args);
        $searchResult = $this->acaraSyaifulV2->getAcaraSyaifulBySearchCriteria($searchCriteria);
        $pageSize = (int) $searchCriteria->getPageSize();
        $totalCount = (int) $searchResult->getTotalCount();
        $totalPages = ceil($totalCount / $pageSize);

        $data = [
            'total_count' => $totalCount,
            'items' => $searchResult->getItems() ?? [],
            'page_info' => [
                'page_size' => $pageSize,
                'current_page' => $searchCriteria->getCurrentPage(),
                'total_pages' => $totalPages
            ]
        ];

        foreach($data['items'] as $keys => $items){
            $peserta = $this->pesertaSyaifulRepository->findPesertaByAcaraId($items->getEntityId());
            $data['items'][$keys]['peserta'] = $peserta;
        }

        return $data;
    }
}