<?php

namespace Icube\AutoCategory\Helper\Command;

use Icube\AutoCategory\Repository\AutoCategoryRepository;
use Icube\AutoCategory\Helper\Config;

class AutoCategory
{
	/**
	 * @var AutoCategoryRepository
	 */
	protected $autoCategoryRepo;

	/**
	 * @var Config
	 */
	protected $autoCategoryConfig;

	/**
	 * AutoCategory constructor.
	 *
	 * @param Config $autoCategoryConfig
	 * @param AutoCategoryRepository $autoCategoryRepo
	 */

	public function __construct(
		Config $autoCategoryConfig,
		AutoCategoryRepository $autoCategoryRepo
	) {
		$this->autoCategoryRepo = $autoCategoryRepo;
		$this->autoCategoryConfig = $autoCategoryConfig;
	}

	public function executeAutoCategoryCommand($from)
	{
		$log = new \Monolog\Logger('cronv2');
		$log->pushHandler(new \Monolog\Handler\StreamHandler(BP . '/var/log/cronv2.log'));

		if (!$this->autoCategoryConfig->getConfigEnable()) {
			$log->info($from.' disabled', []);
			return $this;
		}

		if (strtoupper($this->autoCategoryConfig->getConfigCron()) != 'CRON' && strtoupper($from) == 'CRON') {
			$log->info('Cron is not selected', []);
			return $this;
		}

        if (strtoupper($this->autoCategoryConfig->getConfigCron()) == 'CRON' && strtoupper($from) == 'COMMAND') {
			$log->info('Command is not selected', []);
			return $this;
		}

		$filterDate = date('Y-m-d H:i:s', strtotime('-' . $this->autoCategoryConfig->getConfigDaysRange() . ' days', strtotime(date('Y-m-d H:i:s'))));
		$categoryId = 7;

		$collection = $this->autoCategoryRepo->findProductByCategoryAndDateRange($filterDate, $categoryId);

		if ($collection->getSize() > 0) {
			foreach ($collection as $product) {
				$this->autoCategoryRepo->unassignCategoryFromProduct($product, $categoryId);
			}
			return $this;
		}

		$log->info('Data is empty', []);
		return $this;
	}
}
