<?php

declare(strict_types=1);

namespace Icube\OkrDivisiCustomSyaifulOverride\Model\Resolver;

use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Exception\GraphQlNoSuchEntityException;
use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;
use Icube\OkrDivisiCustomSyaifulOverride\Model\AcaraRepository;

/**
 * UpdateAcara
 */

class UpdateAcara extends \Icube\OkrDivisiCustomSyaiful\Model\Resolver\UpdateAcara implements ResolverInterface
{
    /**
     * @var AcaraRepository
     */
    private $acaraRepository;
    /**
     * UpdateAcara constructor.
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

        $data = $this->acaraRepository->update(@$args['input']["entity_id"], @$args['input']["nama"], @$args['input']["pemateri"], @$args['input']['tanggal']);

        if ($data['status'] == "gagal") {
            throw new GraphQlNoSuchEntityException(
                __('Acara tidak ditemukan')
            );
        }

        return $data;
    }
}
