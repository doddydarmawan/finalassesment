<?php 

declare(strict_types=1);

namespace Icube\OkrDivisiCustomSyaiful\Model\Resolver;

use Icube\OkrDivisiCustomSyaiful\Api\AcaraRepositoryInterface;
use Icube\OkrDivisiCustomSyaiful\Api\PesertaRepositoryInterface;
use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Exception\GraphQlAuthorizationException;
use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;

class EditAcaraSyaiful implements ResolverInterface
{
    /**
     * Acara interface with data management
     *
     * @var AcaraRepositoryInterface
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
     * @param AcaraRepositoryInterface $acaraRepository
     */
    public function __construct(
        AcaraRepositoryInterface $acaraRepository,
        PesertaRepositoryInterface $pesertaRepositoryInterface
    )  {
        $this->acaraRepository = $acaraRepository;
        $this->pesertaRepository = $pesertaRepositoryInterface;
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

        $acara = $this->acaraRepository->update(
            @$args['input']['id'],
            @$args['input']['nama'],
            @$args['input']['pemateri'],
        );

        $acara['id'] = $acara->getData("acara_id");
        $acara['peserta'] = $this->pesertaRepository->getByAcaraId($acara['id']);
        
        return $acara;
    }
}