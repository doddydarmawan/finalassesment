<?php

declare(strict_types=1);

namespace Icube\OkrDivisiCustomSyaifulOverride\Model\Resolver;

use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Exception\GraphQlNoSuchEntityException;
use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;
use Icube\OkrDivisiCustomSyaifulOverride\Model\AcaraRepository;

/**
 * SearchAcara
 */

class SearchAcara implements ResolverInterface
{
    /**
     * @var AcaraRepository
     */
    private $acaraRepository;
    /**
     * SearchAcara constructor.
     * 
     * @param AcaraRepository $acaraRepository
     */

    public function __construct(
        AcaraRepository $acaraRepository
    ) {
        $this->acaraRepository = $acaraRepository;
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
        $search_text = @$args['search'];
        $filter_nama = @$args['filter']['nama']['eq'];
        $filter_pemateri = @$args['filter']['pemateri']['eq'];
        $pageSize = $args['pageSize'];
        $currentPage = $args['currentPage'];

        $data = $this->acaraRepository->SearchAcara($search_text, $filter_nama, $filter_pemateri, $pageSize, $currentPage);

        return $data;
    }
}
