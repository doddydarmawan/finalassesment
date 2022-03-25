<?php 
namespace Icube\OkrDivisiCustomSyaifulOverride\Model\Resolver\CacheIdentity;

use Magento\Framework\GraphQl\Query\Resolver\IdentityInterface;

class SearchCriteriaAcaraCacheIdentities implements IdentityInterface
{
    /**
     * Get identity tags from resolved data
     *
     * @param array $resolvedData
     * @return string[]
     */
    public function getIdentities(array $resolvedData): array
    {
        // return ['dummy'];

        // $tags = array_unique(array_map(function (int $acaraId): int {
        //     return \Icube\OkrDivisiCustomSyaiful\Model\Acara::CACHE_TAG . '_' . $acaraId;
        // }, $resolvedData['acara_id']));

        $writer = new \Zend_Log_Writer_Stream(BP . '/var/log/mnnLogger.log');
        $logger = new \Zend_Log();
        $logger->addWriter($writer);
        $logger->info('>>>');

        // return $tags ? array_merge($tags, [\Icube\OkrDivisiCustomSyaiful\Model\Acara::CACHE_TAG]) : [];

        $ids = [];
        $items = $resolvedData['items'] ?? [];
        foreach ($items as $item) {
            $ids[] = sprintf('%s_%s', $this->cacheTag, $item['entity_id']);
        }
        
        if (!empty($ids)) {
            $ids[] = $this->cacheTag;
        }

        return $ids;
    }
}