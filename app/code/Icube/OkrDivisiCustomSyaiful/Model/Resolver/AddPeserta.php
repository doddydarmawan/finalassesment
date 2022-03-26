<?php

declare(strict_types=1);

namespace Icube\OkrDivisiCustomSyaiful\Model\Resolver;

use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Exception\GraphQlNoSuchEntityException;
use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;
use Icube\OkrDivisiCustomSyaiful\Model\AcaraRepository;

/**
 * AddPeserta
 */

class AddPeserta implements ResolverInterface
{
    /**
     * @var AcaraRepository
     */
    private $acaraRepository;
    /**
     * AddPeserta constructor.
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

        $data = $this->acaraRepository->create2(@$args['input']['nama'], @$args['input']['acara_id']);

        return $data;
    }
}
