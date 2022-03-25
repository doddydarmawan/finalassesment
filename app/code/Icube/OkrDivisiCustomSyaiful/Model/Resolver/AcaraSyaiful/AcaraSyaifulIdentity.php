<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Icube\AutoCategory\Model\Resolver\AcaraSyaiful;

use Icube\OkrDivisiCustomSyaiful\Model\AcaraSyaiful;
use Magento\Framework\GraphQl\Query\Resolver\IdentityInterface;

/**
 * Identity for multiple resolved categories
 */
class AcaraSyaifulIdentity implements IdentityInterface
{
    /** @var string */
    private $cacheTag = AcaraSyaiful::CACHE_TAG;

    /**
     * Get category IDs from resolved data
     *
     * @param array $resolvedData
     * @return string[]
     */
    public function getIdentities(array $resolvedData): array
    {
        $ids = [];
        $resolvedAcaraSyaifuls = $resolvedData['items'] ?? $resolvedData;
        if (!empty($resolvedAcaraSyaifuls)) {
            foreach ($resolvedAcaraSyaifuls as $category) {
                $ids[] = sprintf('%s_%s', $this->cacheTag, $category['id']);
            }
            if (!empty($ids)) {
                array_unshift($ids, $this->cacheTag);
            }
        }
        return $ids;
    }
}
