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


/**
 * AddAcaraSyaiful
 */
class BuatAcaraSyaiful implements ResolverInterface
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
        $input = @$args['input'];

        if (!preg_match("/^(\d{4})-(\d{2})-(\d{2}) (\d{2}):(\d{2}):(\d{2})$/", $input['tanggal'])){
            throw new GraphQlInputException(__('Format tanggal salah, format harus (YYYY-MM-DD HH:I:S)'));
        }

		$acaraSyaiful = $this->acaraSyaifulRepository->findEventByName($input['nama']);

        if(!empty($acaraSyaiful->getData())){   
            $this->saveAllParticipant($input, $acaraSyaiful->getEntityId());
            $acaraSyaiful['peserta'] = $input['peserta'];
            return $acaraSyaiful;
        }

        $acaraSyaiful = $this->acaraSyaifulRepository->saveData($input);
        $this->saveAllParticipant($input, $acaraSyaiful->getEntityId());
        $acaraSyaiful['peserta'] = $input['peserta'];
        
        return $acaraSyaiful;
    }

    private function saveAllParticipant($input, $acara_id){
        $data = [
            'acara_id' => $acara_id
        ];

        foreach($input['peserta'] as $participants){
            $data['nama'] = $participants['nama'];
            $this->pesertaSyaifulRepository->savePeserta($data);
        }
    }
}