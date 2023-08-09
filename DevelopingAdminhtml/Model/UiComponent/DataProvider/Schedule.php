<?php

namespace TrainingBackend\DevelopingAdminhtml\Model\UiComponent\DataProvider;

class Schedule extends \Magento\Framework\View\Element\UiComponent\DataProvider\DataProvider
{
    /**
     * Returns search criteria
     *
     * @return \Magento\Framework\Api\Search\SearchCriteria
     */
    public function getSearchCriteria()
    {
        if (!$this->searchCriteria) {
            if (empty($this->request->getParam('filters')['event_id'])) {
                $this->searchCriteria = $this->searchCriteriaBuilder->addFilter(
                    $this->filterBuilder->setField('event_id')->setValue(3)->setConditionType('eq')->create()
                )->create();
            } else {
                $this->searchCriteria = $this->searchCriteriaBuilder->create();
            }
            $this->searchCriteria->setRequestName($this->name);
        }
        return $this->searchCriteria;
    }

    /**
     * @inheritdoc
     */
    public function addFilter(\Magento\Framework\Api\Filter $filter)
    {
        if (!empty($this->request->getParam('filters')['event_id'])) {
            $this->searchCriteriaBuilder->addFilter(
                $this->filterBuilder->setField('event_id')->setValue($this->request->getParam('filters')['event_id'])->setConditionType('eq')->create()
            )->create();
        } else {
            parent::addFilter($filter);
        }
    }
}
