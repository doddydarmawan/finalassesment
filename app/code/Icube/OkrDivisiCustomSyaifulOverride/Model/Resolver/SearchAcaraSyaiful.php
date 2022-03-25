<?php 

declare(strict_types=1);

namespace Icube\OkrDivisiCustomSyaifulOverride\Model\Resolver;

use Icube\OkrDivisiCustomSyaiful\Api\PesertaRepositoryInterface;
use Icube\OkrDivisiCustomSyaifulOverride\Helper\SearchCriteriaHelper;
use Icube\OkrDivisiCustomSyaifulOverride\Model\AcaraRepository;
use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Exception\GraphQlAuthorizationException;
use Magento\Framework\GraphQl\Exception\GraphQlInputException;
use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;

class SearchAcaraSyaiful implements ResolverInterface
{
    /**
     * @var SearchCriteriaHelper
     */
    private $searchCriteriaHelper;

    /**
     * @var AcaraRepository
     */
    private $acaraRepository;

    /**
     * SearchTrainer construct
     *
     * @param SearchCriteriaHelper $searchCriteriaHelper
     * @param AcaraRepository $acaraRepository
     * @param PesertaRepositoryInterface $pesertaRepository
     */
    public function __construct(
        SearchCriteriaHelper $searchCriteriaHelper,
        AcaraRepository $acaraRepository,
        PesertaRepositoryInterface $pesertaRepository
    )  {
        $this->searchCriteriaHelper = $searchCriteriaHelper;
        $this->acaraRepository = $acaraRepository;
        $this->pesertaRepository = $pesertaRepository;
    }

    /**
     * {@inheritDoc}
     */
    public function resolve(
        Field $field, 
        $context, 
        ResolveInfo $info, 
        array $value = null, 
        array $args = null
    ) {
        $customerId = $context->getUserId();
        
        if (!$customerId && 0 === $customerId) {
            throw new GraphQlAuthorizationException(__('The current user cannot perform on getTrainerById'));
        }

        if ($args['currentPage'] < 1) {
            throw new GraphQlInputException(__('currentPage value must be greater than 0'));
        }

        if ($args['pageSize'] < 1) {
            throw new GraphQlInputException(__('pageSize value must be greater than 0'));
        }

        $searchCriteria = $this->searchCriteriaHelper->build($args);
        $searchResult = $this->acaraRepository->getAcaraBySearchCriteria($searchCriteria);
        $pageSize = (int) $searchCriteria->getPageSize();
        $totalCount = (int) $searchResult->getTotalCount();
        $totalPages = ceil($totalCount / $pageSize);

        $items = [];
        foreach($searchResult->getItems() as $item) {
            $acaraId = $item->getId();
            $items[$acaraId]['id'] = $acaraId;
            $items[$acaraId]['nama'] = $item->getNama();
            $items[$acaraId]['pemateri'] = $item->getPemateri();
            $items[$acaraId]['tanggal'] = $item->getTanggal();
            $items[$acaraId]['peserta'] = $this->pesertaRepository->getByAcaraId($acaraId);
        }

        $data = [
            'total_count' => $totalCount,
            'items' => $items,
            'page_info' => [
                'page_size' => $pageSize,
                'current_page' => $searchCriteria->getCurrentPage(),
                'total_pages' => $totalPages
            ]
        ];
        
        return $data;
    }
}