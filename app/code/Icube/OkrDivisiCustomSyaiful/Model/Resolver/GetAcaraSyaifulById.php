<?php

declare(strict_types=1);

namespace Icube\OkrDivisiCustomSyaiful\Model\Resolver;

use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Exception\GraphQlInputException;
use Magento\Framework\GraphQl\Exception\GraphQlAuthorizationException;
use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;
use Icube\OkrDivisiCustomSyaiful\Model\AcaraSyaifulFactory;
use Icube\OkrDivisiCustomSyaiful\Model\PesertaSyaifulFactory;
use Icube\OkrDivisiCustomSyaiful\Repository\AcaraSyaifulRepository;
use Icube\OkrDivisiCustomSyaiful\Repository\PesertaSyaifulRepository;
use Magento\Framework\GraphQl\Exception\GraphQlNoSuchEntityException;


/**
 * AddAcaraSyaiful
 */
class GetAcaraSyaifulById implements ResolverInterface
{
    /**
     * @var AcaraSyaifulFactory
     */
	protected $acaraSyaifulFactory;
    
    /**
     * @var AcaraSyaifulRepository
     */
	protected $acaraSyaifulRepository;

    /**
     * @var PesertaSyaifulRepository
     */
	protected $pesertaSyaifulRepository;

    /**
     * @var PesertaSyaifulFactory
     */
	protected $pesertaSyaifulFactory;

    /**
     * GetAcaraSyaifulById constructor.
     *
     * @param AcaraSyaifulFactory $acaraSyaifulFactory
     * @param AcaraSyaifulRepository $acaraSyaifulRepository
     * @param PesertaSyaifulFactory $pesertaSyaifulFactory
     * @param PesertaSyaifulRepository $pesertaSyaifulRepository
     */
    public function __construct(
        AcaraSyaifulFactory $acaraSyaifulFactory,
        AcaraSyaifulRepository $acaraSyaifulRepository,
        PesertaSyaifulFactory $pesertaSyaifulFactory,
        PesertaSyaifulRepository $pesertaSyaifulRepository
    ) {
        $this->acaraSyaifulFactory = $acaraSyaifulFactory;
        $this->acaraSyaifulRepository = $acaraSyaifulRepository;
        $this->pesertaSyaifulFactory = $pesertaSyaifulFactory;
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
		$acaraSyaiful = $this->acaraSyaifulRepository->findEventById(@$args['id']);

        if($acaraSyaiful->getData() == null){
            throw new GraphQlNoSuchEntityException(__('Acara tidak ditemukan'));
        }

        $acaraSyaiful['peserta'] = $this->pesertaSyaifulRepository->findPesertaByAcaraId($acaraSyaiful->getEntityId()) ?? [];
        
        return $acaraSyaiful;
    }
}