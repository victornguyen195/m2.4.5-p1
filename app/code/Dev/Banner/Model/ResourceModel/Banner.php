<?php

namespace Dev\Banner\Model\ResourceModel;

class Banner extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
	public function __construct(
		\Magento\Framework\Model\ResourceModel\Db\Context $context
	) {
		parent::__construct($context);
	}

	protected function _construct()
	{
        // <main-table>-<primary-key>
		$this->_init('banner', 'banner_id');
	}
}
