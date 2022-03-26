<?php

declare(strict_types=1);


namespace Icube\OkrDivisiCustomSyaifulOverride\Model\Resolver\SearchAcara;

use Magento\Framework\GraphQl\Query\Resolver\IdentityInterface;

/**
 * Get identities from resolved data
 */
class MyIdentity implements IdentityInterface
{
    private $cacheTag = "icube_okrdivisicustomsyaifuloverride_searchacara";

    /**
     * Get identity tags from resolved data
     *
     * @param array $resolvedData
     * @return string[]
     */
    public function getIdentities(array $resolvedData): array
    {
        $writer = new \Zend\Log\Writer\Stream(BP . '/var/log/test_cache.log');
        $logger = new \Zend\Log\Logger();
        $logger->addWriter($writer);
        $logger->info("a");
        $ids = [];
        $items = $resolvedData['acaraList'] ?? [];
        foreach ($items as $item) {
            $ids[] = sprintf('%s_%s', $this->cacheTag, $item['entity_id']);
            $logger->info("b");
        }
        if (!empty($ids)) {
            $ids[] = $this->cacheTag;
        }
        return $ids;
    }
}
