<?php

declare(strict_types=1);

namespace Icube\OkrDivisiCustomSyaiful\Model\Resolver;

use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Exception\GraphQlInputException;
use Magento\Framework\GraphQl\Exception\GraphQlAuthorizationException;
use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;
use Icube\OkrDivisiCustomSyaiful\Repository\AcaraSyaifulRepository;
use Icube\OkrDivisiCustomSyaiful\Repository\PesertaSyaifulRepository;
use Magento\Framework\GraphQl\Exception\GraphQlNoSuchEntityException;


/**
 * AddAcaraSyaiful
 */
class EditAcaraSyaiful implements ResolverInterface
{
   
    /**
     * @var AcaraSyaifulRepository
     */
	protected $acaraSyaifulRepository;

    /**
     * @var PesertaSyaifulRepository
     */
	protected $pesertaSyaifulRepository;

    /**
     * GetAcaraSyaifulById constructor.
     *
     * @param AcaraSyaifulFactory $acaraSyaifulFactory
     * @param AcaraSyaifulRepository $acaraSyaifulRepository
     * @param PesertaSyaifulFactory $pesertaSyaifulFactory
     * @param PesertaSyaifulRepository $pesertaSyaifulRepository
     */
    public function __construct(
        AcaraSyaifulRepository $acaraSyaifulRepository,
        PesertaSyaifulRepository $pesertaSyaifulRepository
    ) {
        $this->acaraSyaifulRepository = $acaraSyaifulRepository;
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
        $input = @$args['input'];

		$acaraSyaiful = $this->acaraSyaifulRepository->findEventById($input['id']);

        if($acaraSyaiful->getData() == null){   
            throw new GraphQlNoSuchEntityException(__('Acara tidak ditemukan'));
        }

        $editAcaraSyaiful = $this->acaraSyaifulRepository->edit($input);
        $editAcaraSyaiful['peserta'] = $this->pesertaSyaifulRepository->findPesertaByAcaraId($editAcaraSyaiful->getEntityId()) ?? [];
        
        return $editAcaraSyaiful;
    }
}