<?php

namespace TrainingBackend\SalesOperations\Ui\Customer\Component\Button;

use Magento\Framework\Escaper;
use Magento\Framework\UrlInterface;

class DataProvider
{
    /**
     * @var Escaper
     */
    private $escaper;

    /**
     * @var UrlInterface
     */
    private $urlBuilder;

    /**
     * @var array
     */
    private $data;

    /**
     * @param Escaper $escaper
     * @param UrlInterface $urlBuilder
     * @param array $data
     */
    public function __construct(
        Escaper $escaper,
        UrlInterface $urlBuilder,
        array $data = []
    ) {
        $this->escaper = $escaper;
        $this->urlBuilder = $urlBuilder;
        $this->data = $data;
    }

    /**
     * Get data for Login as Customer button.
     *
     * @param int $customerId
     * @return array
     */
    public function getData(int $customerId): array
    {
        return $this->data;
    }
}
