<?php

namespace TrainingBackend\ArchitectureAndCustomization\Console;

use Magento\Framework\Console\Cli;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Magento\Sales\Model\ResourceModel\Order\CollectionFactory;

class ClearOrderStatus extends Command
{
    protected $orderCollectionFactory;

    public function __construct
    (
        CollectionFactory $orderCollectionFactory,
        string            $name = null
    )
    {
        $this->orderCollectionFactory = $orderCollectionFactory;
        parent::__construct($name);
    }

    protected function configure()
    {
        $options = [
            new InputOption(
                'status',
                null,
                InputOption::VALUE_REQUIRED,
                'Order status'
            ),
        ];
        $this->setName('order:clear')
            ->setDescription('cancel all orders that are in {status} status without further processing and without any updates within 1 hour.')
            ->setDefinition($options);
        parent::configure();
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        try {
            $collection = $this->orderCollectionFactory->create()
                ->addFieldToFilter('status', $input->getOption('status'))
                ->addFieldToFilter('updated_at', ['lteq' => date('Y-m-d H:i:s', strtotime('-1 hour'))]);
            foreach ($collection as $order) {
                /** @var \Magento\Sales\Model\Order $order */
                $order->setState(\Magento\Sales\Model\Order::STATE_CANCELED)
                    ->setStatus(\Magento\Sales\Model\Order::STATE_CANCELED)
                    ->addStatusToHistory($order->getStatus(), 'Order canceled')
                    ->save();
            }
            $output->writeln($collection->getSize() . ' order canceled');
        } catch (\Exception $exception) {
            $output->writeln($exception->getMessage());
            return Cli::RETURN_FAILURE;
        }
        return Cli::RETURN_SUCCESS;
    }
}
