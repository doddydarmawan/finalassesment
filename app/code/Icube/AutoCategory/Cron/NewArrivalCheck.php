<?php

namespace Icube\AutoCategory\Cron;

use Icube\AutoCategory\Helper\Command\AutoCategory;

class NewArrivalCheck
{
	/**
	 * @var AutoCategory
	 */
	protected $autoCategoryHelper;

	/**
	 * AutoCategory constructor.
	 *
	 * @param AutoCategory $autoCategoryHelper
	 */

	public function __construct(
		AutoCategory $autoCategoryHelper
	) {
		$this->autoCategoryHelper = $autoCategoryHelper;
	}

	public function execute()
	{
		$executeCommand = $this->autoCategoryHelper->executeAutoCategoryCommand('CRON');
		return $executeCommand;
	}
}
