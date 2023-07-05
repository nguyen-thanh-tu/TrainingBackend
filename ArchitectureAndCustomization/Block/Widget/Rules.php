<?php

namespace TrainingBackend\ArchitectureAndCustomization\Block\Widget;

use Magento\Framework\View\Element\Template;
use Magento\Widget\Block\BlockInterface;
use TrainingBackend\ArchitectureAndCustomization\Model\Config\Reader;
use Magento\Framework\Logger\Monolog;
use Magento\Framework\Serialize\SerializerInterface;
use Magento\Framework\HTTP\PhpEnvironment\RemoteAddress;
use Magento\Framework\App\CacheInterface;
use TrainingBackend\ArchitectureAndCustomization\Model\Cache\Type\CacheType;
use TrainingBackend\ArchitectureAndCustomization\Model\ResourceModel\CustomerDirectory\CollectionFactory;

class Rules extends Template implements BlockInterface
{
    protected $reader;
    protected $logger;
    protected $serializer;
    protected $remoteAddress;

    public function __construct
    (
        Template\Context    $context,
        Reader              $reader,
        Monolog             $logger,
        SerializerInterface $serializer,
        RemoteAddress       $remoteAddress,
        CacheInterface      $cache,
        CollectionFactory   $collection,
        array               $data = []
    )
    {
        $this->reader = $reader;
        $this->logger = $logger;
        $this->serializer = $serializer;
        $this->remoteAddress = $remoteAddress;
        $this->cache = $cache;
        $this->collection = $collection;
        parent::__construct($context, $data);
        $this->logger->debug('IP: ' . $this->remoteAddress->getRemoteAddress() . '. Log params: ' . $this->serializer->serialize($this->getRequest()->getParams()));
    }

    public function getRules()
    {
        $rules = $this->reader->read();
        $result = [];
        if (!empty($rules['config']['acl']['resources'])) {
            $result = $this->sortRules($rules['config']['acl']['resources']);
        }
        return $result;
    }

    public function sortRules(array $resources)
    {
        foreach ($resources as $k => $resource) {
            if ($resource['disabled'] == false) {
                if (!empty($resource['children'])) {
                    $resources[$k]['children'] = $this->sortRules($resource['children']);
                }
            }
        }
        usort($resources, fn($a, $b) => $a['sortOrder'] <=> $b['sortOrder']);
        return $resources;
    }

    public function getCacheBlockData()
    {
        $data = $this->getCache();
        if(empty($data)){
            $collection = $this->collection->create();
            foreach($collection as $item){
                $data[] = $item->getData();
            }
            $this->saveCache($data);
        }
        return $data;
    }

    public function saveCache($data)
    {
        $cacheKey = CacheType::TYPE_IDENTIFIER;
        $cacheTag = CacheType::CACHE_TAG;
        $cacheLifeTime = CacheType::CACHE_LIFETIME;
        $cacheData = $this->getCache();
        $storeData = [];
        if(empty($cacheData)){
            $storeData = $this->cache->save(
                $this->serializer->serialize($data),
                $cacheKey,
                [$cacheTag],
                $cacheLifeTime
            );
        }
        return $storeData;
    }

    public function getCache()
    {
        $cacheKey = CacheType::TYPE_IDENTIFIER;
        $cache = $this->cache->load($cacheKey);
        if($cache){
            return $this->serializer->unserialize(
                $cache
            );
        }
        return [];
    }
}
