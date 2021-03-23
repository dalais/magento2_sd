<?php
namespace Pulsestorm\RepositoryTutorial\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Examples extends Command
{
    protected $objectManager;
    protected $appState;
    public function __construct(
        \Magento\Framework\ObjectManagerInterface $objectManager,
        \Magento\Framework\App\State $appState,
        $name=null
    )
    {
        $this->objectManager = $objectManager;
        $this->appState = $appState;
        parent::__construct($name);
    }

    protected function configure()
    {
        $this->setName("ps:examples");
        $this->setDescription("A command the programmer was too lazy to enter a description for.");
        parent::configure();
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->appState->setAreaCode('frontend');
        //create our filter
        /*$filter_1 = $this->objectManager
            ->create('Magento\Framework\Api\FilterBuilder')
            ->setField('sku')
            ->setConditionType('like')
            ->setValue('WSH11-28%Red')
            ->create();

        $filter_2 = $this->objectManager
            ->create('Magento\Framework\Api\FilterBuilder')
            ->setField('sku')
            ->setConditionType('like')
            ->setValue('WSH11-28%Blue')
            ->create();*/

        //add our filter(s) to a group
        /*$filter_group_1 = $this->objectManager
            ->create('Magento\Framework\Api\Search\FilterGroupBuilder')
            ->addFilter($filter_1)
            ->create();

        $filter_group_2 = $this->objectManager
            ->create('Magento\Framework\Api\Search\FilterGroupBuilder')
            ->addFilter($filter_2)
            ->create();*/
        // $filter_group->setData('filters', [$filter]);

        //add the group(s) to the search criteria object
        /*$search_criteria = $this->objectManager
            ->create('Magento\Framework\Api\SearchCriteriaBuilder')
            ->setFilterGroups([$filter_group_1, $filter_group_2])
            ->create();*/



        //create our filter
        $filter = $this->objectManager->create('Magento\Framework\Api\Filter');
        $filter->setData('field','sku');
        $filter->setData('value','WSH11%');
        $filter->setData('condition_type','like');

        //add our filter(s) to a group
        $filter_group = $this->objectManager->create('Magento\Framework\Api\Search\FilterGroup');
        $filter_group->setData('filters', [$filter]);

        //add the group(s) to the search criteria object
        $search_criteria = $this->objectManager->create('Magento\Framework\Api\SearchCriteriaInterface');
        $search_criteria->setFilterGroups([$filter_group]);

        //query the repository for the object(s)
        $repo = $this->objectManager->get('Magento\Catalog\Model\ProductRepository');
        $result = $repo->getList($search_criteria);
        $products = $result->getItems();
        foreach($products as $product)
        {
            echo $product->getSku(),"\n";
        }
    }
}
