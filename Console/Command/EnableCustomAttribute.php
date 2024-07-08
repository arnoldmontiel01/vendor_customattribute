<?php
namespace Vendor\CustomAttribute\Console\Command;

use Magento\Framework\App\Config\Storage\WriterInterface;
use Magento\Framework\App\State;
use Magento\Framework\Console\Cli;
use Magento\Framework\Exception\LocalizedException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Vendor\CustomAttribute\Helper\Data as CustomAttributeHelper;

class EnableCustomAttribute extends Command
{
    protected $configWriter;
    protected $state;
    protected $customAttributeHelper;

    public function __construct(
        WriterInterface $configWriter,
        State $state,
        CustomAttributeHelper $customAttributeHelper
    ) {
        $this->configWriter = $configWriter;
        $this->state = $state;
        $this->customAttributeHelper = $customAttributeHelper;
        parent::__construct();
    }

    protected function configure()
    {
        $this->setName('custom:attribute:enable')
            ->setDescription('Enable custom attribute functionality');
        parent::configure();
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        try {
            $this->state->setAreaCode(\Magento\Framework\App\Area::AREA_GLOBAL);

            if ($this->customAttributeHelper->isCustomAttributeEnabled()) {
                $output->writeln('<info>Custom attribute functionality is already enabled.</info>');
                return Cli::RETURN_SUCCESS;
            }

            $this->configWriter->save(CustomAttributeHelper::XML_PATH_CUSTOMATTRIBUTE_ENABLE, 1);
            $output->writeln('<info>Custom attribute functionality enabled successfully.</info>');
            return Cli::RETURN_SUCCESS;
        } catch (LocalizedException $e) {
            $output->writeln('<error>' . $e->getMessage() . '</error>');
            return Cli::RETURN_FAILURE;
        } catch (\Exception $e) {
            $output->writeln('<error>Something went wrong while enabling custom attribute functionality.</error>');
            return Cli::RETURN_FAILURE;
        }
    }
}

