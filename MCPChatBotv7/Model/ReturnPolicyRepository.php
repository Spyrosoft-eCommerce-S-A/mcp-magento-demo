<?php
declare(strict_types=1);

namespace Spyrosoft\MCPChatBotv7\Model;

use Spyrosoft\MCPChatBotv7\Api\ReturnPolicyRepositoryInterface;
use Spyrosoft\MCPChatBotv7\Api\Data\ReturnPolicyInterface;
use Spyrosoft\MCPChatBotv7\Api\Data\ReturnPolicyInterfaceFactory;
use Spyrosoft\MCPChatBotv7\Enum\ApiEnum;
use Magento\Cms\Api\BlockRepositoryInterface;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Exception\NoSuchEntityException;

class ReturnPolicyRepository implements ReturnPolicyRepositoryInterface
{
    private ReturnPolicyInterfaceFactory $returnPolicyFactory;
    private BlockRepositoryInterface $blockRepository;
    private SearchCriteriaBuilder $searchCriteriaBuilder;

    public function __construct(
        ReturnPolicyInterfaceFactory $returnPolicyFactory,
        BlockRepositoryInterface $blockRepository,
        SearchCriteriaBuilder $searchCriteriaBuilder
    ) {
        $this->returnPolicyFactory = $returnPolicyFactory;
        $this->blockRepository = $blockRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
    }

    public function getReturnPolicy(): ReturnPolicyInterface
    {
        $returnPolicy = $this->returnPolicyFactory->create();
        $policyText = ApiEnum::DEFAULT_POLICY;

        $searchCriteria = $this->searchCriteriaBuilder
            ->addFilter('identifier', ApiEnum::RETURN_POLICY)
            ->create();
        $blocks = $this->blockRepository->getList($searchCriteria)->getItems();
        if (!empty($blocks)) {
            $cmsBlock = array_shift($blocks);
            if ($cmsBlock && $cmsBlock->isActive()) {
                $policyText = $cmsBlock->getContent();
            }
        }

        $returnPolicy->setPolicyText($policyText);
        return $returnPolicy;
    }
}
