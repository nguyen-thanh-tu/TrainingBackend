<?php

namespace TrainingBackend\WorkingDatabases\Model\Resolver;

use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Exception\GraphQlInputException;
use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\GraphQl\Exception\GraphQlNoSuchEntityException;

class CustomerTrainingGraphql implements ResolverInterface
{
    protected $customerTrainingApi;

    public function __construct
    (
        \TrainingBackend\WorkingDatabases\Model\Api\CustomerTrainingApi $customerTrainingApi
    )
    {
        $this->customerTrainingApi = $customerTrainingApi;
    }

    /**
     * @param Field $field
     * @param \Magento\Framework\GraphQl\Query\Resolver\ContextInterface $context
     * @param ResolveInfo $info
     * @param array|null $value
     * @param array|null $args
     * @return array|\Magento\Framework\GraphQl\Query\Resolver\Value|mixed
     * @throws GraphQlInputException
     */
    public function resolve(
        Field $field,
              $context,
        ResolveInfo $info,
        array $value = null,
        array $args = null)
    {
        if($args['action'] == 'get'){
            $result = $this->customerTrainingApi->get($args['storecode']);
        } elseif ($args['action'] == 'update'){
            $result = $this->customerTrainingApi->update($args['id'], $args['fristname'], $args['lastname'], $args['address'], $args['city'], $args['age'], $args['storecode']);
        } elseif ($args['action'] == 'create'){
            $result = $this->customerTrainingApi->create($args['fristname'], $args['lastname'], $args['address'], $args['city'], $args['age'], $args['storecode']);
        } elseif ($args['action'] == 'delete'){
            $result = $this->customerTrainingApi->delete($args['id'], $args['storecode']);
        }
        if(is_array($result)){
            $output = [];
            foreach($result as $item) {
                $output[] = $item->getData();
            }
        }else{
            $output = [$result->getData()];
        }
        return $output ;
    }
}
