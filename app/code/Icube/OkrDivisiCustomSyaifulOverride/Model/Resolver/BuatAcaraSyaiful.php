<?php 

declare(strict_types=1);

namespace Icube\OkrDivisiCustomSyaifulOverride\Model\Resolver;

use Icube\OkrDivisiCustomSyaifulOverride\Model\AcaraRepository;
use Icube\OkrDivisiCustomSyaiful\Api\PesertaRepositoryInterface;
use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Exception\GraphQlAuthorizationException;
use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;

class BuatAcaraSyaiful implements ResolverInterface
{
    /**
     * Acara interface with data management
     *
     * @var AcaraRepository
     */
    private $acaraRepository;

    /**
     * Peserta interface with data management
     *
     * @var PesertaRepositoryInterface
     */
    private $pesertaRepository;

    /**
     * GetAcaraSyaifulById construct
     *
     * @param AcaraRepository $acaraRepository
     * @param PesertaRepositoryInterface @pesertaRepository
     */
    public function __construct(
        AcaraRepository $acaraRepository,
        PesertaRepositoryInterface $pesertaRepository
    )  {
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
            throw new GraphQlAuthorizationException(
                __('The current user cannot perform on getAcaraSyaifulById')
            );
        }

        if (count(@$args['input']['peserta']) <= 0) {
            throw new Magento\Framework\Exception\NoSuchEntityException(
                __('Peserta does not exist, please insert data peserta')
            );
        }

        $acara = $this->acaraRepository->create(
            @$args['input']['nama'],
            @$args['input']['pemateri'],
            @$args['input']['tanggal'],
        );

        $peserta = [];
        
        foreach (@$args['input']['peserta'] as $peserta) {
            $peserta = $this->pesertaRepository->create(
                $acara->getData("acara_id"),
                $peserta['name']
            );

            $peserta['nama'] = $peserta['name'];
        }

        $acara['id'] = $acara->getData("acara_id");
        $acara['peserta'] = $this->pesertaRepository->getByAcaraId($acara['id']);
        
        return $acara;
    }
}