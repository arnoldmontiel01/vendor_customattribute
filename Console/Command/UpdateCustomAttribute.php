<?php
namespace Vendor\CustomAttribute\Console\Command;

use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Catalog\Model\Product\Action as ProductAction;
use Magento\Framework\App\State;
use Magento\Framework\Console\Cli;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory as ProductCollectionFactory;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Vendor\CustomAttribute\Helper\Data as CustomAttributeHelper;

class UpdateCustomAttribute extends Command
{
    const ATTRIBUTE_CODE = 'custom_text_attribute';
    const INPUT_KEY_VALUE = 'value';

    protected $productRepository;
    protected $state;
    protected $productAction;
    protected $productCollectionFactory;
    protected $customAttributeHelper;

    public function __construct(
        ProductRepositoryInterface $productRepository,
        State $state,
        ProductAction $productAction,
        ProductCollectionFactory $productCollectionFactory,
        CustomAttributeHelper $customAttributeHelper

    ) {
        $this->productRepository = $productRepository;
        $this->state = $state;
        $this->productAction = $productAction;
        $this->productCollectionFactory = $productCollectionFactory;
        $this->customAttributeHelper = $customAttributeHelper;
        parent::__construct();
    }

    protected function configure()
    {
        $this->setName('custom:attribute:update')
            ->setDescription('Update custom attribute for all products')
            ->addArgument(self::INPUT_KEY_VALUE, InputArgument::REQUIRED, 'Value');
        parent::configure();
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        try {
            $this->state->setAreaCode(\Magento\Framework\App\Area::AREA_GLOBAL);
            if (!$this->customAttributeHelper->isCustomAttributeEnabled()) {
                $output->writeln('<error>Custom attribute functionality is disabled.</error>');
                return Cli::RETURN_FAILURE;
            }

            $value = $input->getArgument(self::INPUT_KEY_VALUE);

            // Get all product IDs
            $productCollection = $this->productCollectionFactory->create();
            $productIds = $productCollection->getAllIds();

            // Update custom attribute for all products
            $this->productAction->updateAttributes(
                $productIds,
                [self::ATTRIBUTE_CODE => $value],
                0 // 0 means default store view
            );

            $output->writeln('<info>Custom attribute updated successfully for '.count($productIds).' products.</info>');
            return Cli::RETURN_SUCCESS;
        } catch (LocalizedException $e) {
            $output->writeln('<error>' . $e->getMessage() . '</error>');
            return Cli::RETURN_FAILURE;
        } catch (\Exception $e) {
            $output->writeln('<error>Something went wrong while updating custom attribute.</error>');
            return Cli::RETURN_FAILURE;
        }
    }
}
