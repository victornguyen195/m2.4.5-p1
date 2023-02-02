<?php

declare(strict_types=1);

namespace Dev\Email\Setup\Patch\Data;

use Magento\Framework\Module\Dir;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Email\Model\TemplateFactory;
use Magento\Email\Model\ResourceModel\Template as TemplateResource;
use Magento\Framework\Filesystem\Driver\File;
use Magento\Framework\Module\Dir\Reader;

class DemoEmailTemplate implements DataPatchInterface
{
    protected const MODULE_DIR = 'Dev_Email';
    protected const TEMPLATE_CODE = "Load demo email";
    protected const TEMPLATE_SUBJECT = "Test load demo email";
    protected const TEMPLATE_NAME = 'email_demo_template';
    protected const TEMPLATE_TYPE_HTML = 2;

    /** @var TemplateFactory */
    protected TemplateFactory $templateFactory;

    /** @var TemplateResource */
    protected TemplateResource $templateResource;

    /** @var File */
    protected File $filesystem;

    /** @var Reader */
    protected Reader $moduleReader;

    /**
     * @param TemplateFactory  $templateFactory
     * @param TemplateResource $templateResource
     * @param File             $filesystem
     * @param Reader           $moduleReader
     */
    public function __construct(
        TemplateFactory  $templateFactory,
        TemplateResource $templateResource,
        File             $filesystem,
        Reader           $moduleReader
    ) {
        $this->templateFactory = $templateFactory;
        $this->templateResource = $templateResource;
        $this->filesystem = $filesystem;
        $this->moduleReader = $moduleReader;
    }

    /**
     * @inheritDoc
     */
    public function apply()
    {
        $template = $this->templateFactory->create();

        $templateText = $this->filesystem->fileGetContents($this->getDirectory(self::TEMPLATE_NAME . '.html'));

        $template->setTemplateSubject(self::TEMPLATE_SUBJECT)
            ->setTemplateCode(self::TEMPLATE_CODE)
            ->setTemplateText($templateText)
            ->setTemplateType(self::TEMPLATE_TYPE_HTML);
        $this->templateResource->save($template);
    }

    /**
     * Returns email directory
     *
     * @param string $templateName
     *
     * @return string
     */
    protected function getDirectory(string $templateName): string
    {
        $viewDir = $this->moduleReader->getModuleDir(
            Dir::MODULE_VIEW_DIR,
            self::MODULE_DIR
        );
        return $viewDir . '/frontend/email/' . $templateName;
    }

    /**
     * @inheritDoc
     */
    public static function getDependencies()
    {
        return [];
    }

    /**
     * @inheritDoc
     */
    public function getAliases()
    {
        return [];
    }
}
