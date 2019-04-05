<?php

namespace Mirasvit\Blog\Model;

use Magento\Framework\Image as MagentoImage;
use Magento\Framework\Image\Factory as ImageFactory;
use Magento\Framework\Model\AbstractExtensibleModel;
use Magento\Framework\Api\AttributeValueFactory;
use Magento\Framework\Model\Context;
use Magento\Framework\Registry;
use Magento\Framework\Api\ExtensionAttributesFactory;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\DataObject\IdentityInterface;
use Mirasvit\Blog\Api\Data\CategoryInterface;
use Mirasvit\Blog\Api\Data\PostInterface;
use Mirasvit\Blog\Api\Data\TagInterface;
use Mirasvit\Blog\Api\Repository\AuthorRepositoryInterface;
use Mirasvit\Blog\Api\Repository\CategoryRepositoryInterface;
use Mirasvit\Blog\Api\Repository\TagRepositoryInterface;
use Mirasvit\Blog\Model\ResourceModel\Tag\CollectionFactory as TagCollectionFactory;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory as ProductCollectionFactory;

/**
 * @method string getFeaturedShowOnHome()
 * @method int getParentId()
 * @method $this setParentId($parent)
 *
 * @method ResourceModel\Post getResource()
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class Post extends AbstractExtensibleModel implements IdentityInterface, PostInterface
{
    const ENTITY = 'blog_post';
    const CACHE_TAG = 'blog_post';

    /**
     * @var MagentoImage
     */
    protected $_processor;

    /**
     * @var Url
     */
    protected $url;

    /**
     * @var StoreManagerInterface
     */
    protected $storeManager;

    /**
     * @var CategoryRepositoryInterface
     */
    private $categoryRepository;

    /**
     * @var TagRepositoryInterface
     */
    private $tagRepository;

    /**
     * @var AuthorRepositoryInterface
     */
    private $authorRepository;

    /**
     * @var Config
     */
    protected $config;

    public function __construct(
        CategoryRepositoryInterface $categoryRepository,
        TagRepositoryInterface $tagRepository,
        AuthorRepositoryInterface $authorRepository,
        ProductCollectionFactory $productCollectionFactory,
        Config $config,
        Url $url,
        StoreManagerInterface $storeManager,
        ImageFactory $imageFactory,
        Context $context,
        Registry $registry,
        ExtensionAttributesFactory $extensionFactory,
        AttributeValueFactory $customAttributeFactory
    ) {
        $this->categoryRepository = $categoryRepository;
        $this->tagRepository = $tagRepository;
        $this->authorRepository = $authorRepository;
        $this->productCollectionFactory = $productCollectionFactory;
        $this->config = $config;
        $this->url = $url;
        $this->storeManager = $storeManager;
        $this->imageFactory = $imageFactory;

        parent::__construct($context, $registry, $extensionFactory, $customAttributeFactory);
    }

    /**
     * {@inheritdoc}
     */
    protected function _construct()
    {
        $this->_init('Mirasvit\Blog\Model\ResourceModel\Post');
    }

    /**
     * {@inheritdoc}
     */
    public function getIdentities()
    {
        return [Category::CACHE_TAG, self::CACHE_TAG . '_' . $this->getId()];
    }

    /**
     * {@inheritdoc}
     */
    public function getType()
    {
        return $this->getData(self::TYPE);
    }

    /**
     * {@inheritdoc}
     */
    public function setType($value)
    {
        return $this->setData(self::TYPE, $value);
    }

    /**
     * {@inheritdoc}
     */
    public function getStatus()
    {
        return $this->getData(self::STATUS);
    }

    /**
     * {@inheritdoc}
     */
    public function setStatus($value)
    {
        return $this->setData(self::STATUS, $value);
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthorId()
    {
        return $this->getData(self::AUTHOR_ID);
    }

    /**
     * {@inheritdoc}
     */
    public function setAuthorId($value)
    {
        return $this->setData(self::AUTHOR_ID, $value);
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return $this->getData(self::NAME);
    }

    /**
     * {@inheritdoc}
     */
    public function setName($value)
    {
        return $this->setData(self::NAME, $value);
    }

    /**
     * {@inheritdoc}
     */
    public function getShortContent()
    {
        return $this->getData(self::SHORT_CONTENT);
    }

    /**
     * {@inheritdoc}
     */
    public function setShortContent($value)
    {
        return $this->setData(self::SHORT_CONTENT, $value);
    }

    /**
     * {@inheritdoc}
     */
    public function getContent()
    {
        return $this->getData(self::CONTENT);
    }

    /**
     * {@inheritdoc}
     */
    public function setContent($value)
    {
        return $this->setData(self::CONTENT, $value);
    }

    /**
     * {@inheritdoc}
     */
    public function getUrlKey()
    {
        return $this->getData(self::URL_KEY);
    }

    /**
     * {@inheritdoc}
     */
    public function setUrlKey($value)
    {
        return $this->setData(self::URL_KEY, $value);
    }

    /**
     * {@inheritdoc}
     */
    public function getMetaTitle()
    {
        return $this->getData(self::META_TITLE);
    }

    /**
     * {@inheritdoc}
     */
    public function setMetaTitle($value)
    {
        return $this->setData(self::META_TITLE, $value);
    }

    /**
     * {@inheritdoc}
     */
    public function getMetaDescription()
    {
        return $this->getData(self::META_DESCRIPTION);
    }

    /**
     * {@inheritdoc}
     */
    public function setMetaDescription($value)
    {
        return $this->setData(self::META_DESCRIPTION, $value);
    }

    /**
     * {@inheritdoc}
     */
    public function getMetaKeywords()
    {
        return $this->getData(self::META_KEYWORDS);
    }

    /**
     * {@inheritdoc}
     */
    public function setMetaKeywords($value)
    {
        return $this->setData(self::META_KEYWORDS, $value);
    }

    /**
     * {@inheritdoc}
     */
    public function getFeaturedImage()
    {
        return $this->getData(self::FEATURED_IMAGE);
    }

    /**
     * {@inheritdoc}
     */
    public function setFeaturedImage($value)
    {
        return $this->setData(self::FEATURED_IMAGE, $value);
    }

    /**
     * {@inheritdoc}
     */
    public function getFeaturedAlt()
    {
        return $this->getData(self::FEATURED_ALT);
    }

    /**
     * {@inheritdoc}
     */
    public function setFeaturedAlt($value)
    {
        return $this->setData(self::FEATURED_ALT, $value);
    }

    /**
     * {@inheritdoc}
     */
    public function getCreatedAt()
    {
        return $this->getData(self::CREATED_AT);
    }

    /**
     * {@inheritdoc}
     */
    public function setCreatedAt($value)
    {
        return $this->setData(self::CREATED_AT, $value);
    }

    /**
     * {@inheritdoc}
     */
    public function isPinned()
    {
        return $this->getData(self::IS_PINNED);
    }

    /**
     * {@inheritdoc}
     */
    public function setIsPinned($value)
    {
        return $this->setData(self::IS_PINNED, $value);
    }

    /**
     * {@inheritdoc}
     */
    public function getCategoryIds()
    {
        return $this->getData(self::CATEGORY_IDS);
    }

    /**
     * {@inheritdoc}
     */
    public function setCategoryIds(array $value)
    {
        return $this->setData(self::CATEGORY_IDS, $value);
    }

    /**
     * {@inheritdoc}
     */
    public function getStoreIds()
    {
        return $this->getData(self::STORE_IDS);
    }

    /**
     * {@inheritdoc}
     */
    public function setStoreIds(array $value)
    {
        return $this->setData(self::STORE_IDS, $value);
    }

    /**
     * {@inheritdoc}
     */
    public function getTagIds()
    {
        return $this->getData(self::TAG_IDS);
    }

    /**
     * {@inheritdoc}
     */
    public function setTagIds(array $value)
    {
        return $this->setData(self::TAG_IDS, $value);
    }

    /**
     * {@inheritdoc}
     */
    public function getProductIds()
    {
        return $this->getData(self::PRODUCT_IDS);
    }

    /**
     * {@inheritdoc}
     */
    public function setProductIds(array $value)
    {
        return $this->setData(self::PRODUCT_IDS, $value);
    }

    //    /**
    //     * @return \Mirasvit\Blog\Model\Category|false
    //     */
    //    public function getCategory()
    //    {
    //        $ids = $this->getCategoryIds();
    //        if (count($ids) == 0) {
    //            return false;
    //        }
    //
    //        $categoryId = reset($ids);
    //        $category = $this->categoryFactory->create()->load($categoryId);
    //
    //        return $category;
    //    }
    //
    /**
     * @return ResourceModel\Category\Collection
     */
    public function getCategories()
    {
        $ids = $this->getCategoryIds();
        $ids[] = 0;

        $collection = $this->categoryRepository->getCollection()
            ->addAttributeToSelect(['*'])
            ->addFieldToFilter(CategoryInterface::ID, $ids);

        return $collection;
    }

    /**
     * @return ResourceModel\Tag\Collection
     */
    public function getTags()
    {
        $ids = $this->getTagIds();
        $ids[] = 0;

        $collection = $this->tagRepository->getCollection()
            ->addFieldToFilter(TagInterface::ID, $ids);

        return $collection;
    }
    //
    //    /**
    //     * @return \Magento\Store\Model\Store|false
    //     */
    //    public function getStore()
    //    {
    //        $ids = $this->getStoreIds();
    //        if (count($ids) == 0) {
    //            return false;
    //        }
    //
    //        $storeId = reset($ids);
    //        $store = $this->storeManager->getStore($storeId);
    //
    //        return $store;
    //    }

    //    /**
    //     * @param int $storeId
    //     * @return bool
    //     */
    //    public function isStoreAllowed($storeId)
    //    {
    //        return in_array(0, $this->getStoreIds()) || in_array($storeId, $this->getStoreIds());
    //    }
    //
        /**
         * @return mixed|\Magento\Catalog\Model\ResourceModel\Product\Collection
         */
    public function getRelatedProducts()
    {
        $ids = $this->getProductIds();
        $url = \Magento\Framework\App\ObjectManager::getInstance()
            ->get('Magento\Framework\UrlInterface');
        if (strpos( $url->getCurrentUrl(), 'rest/all/V1/blog') > 0) {
            return $ids;
        }
        $ids[] = 0;
        $collection = $this->productCollectionFactory->create()
            ->addAttributeToSelect('*')
            ->addFieldToFilter('entity_id', $ids);

        return $collection;
    }
    //
    //    /**
    //     * @return ResourceModel\Tag\Collection
    //     */
    //    public function getTags()
    //    {
    //        $ids = $this->getTagIds();
    //        $ids[] = 0;
    //
    //        $collection = $this->tagCollectionFactory->create()
    //            ->addFieldToFilter('tag_id', $ids);
    //
    //        return $collection;
    //    }

    //    /**
    //     * @return Post
    //     */
    //    public function saveAsRevision()
    //    {
    //        $clone = clone $this;
    //        $clone->setId('')
    //            ->setParentId($this->getId())
    //            ->setType(self::TYPE_REVISION)
    //            ->save();
    //
    //        return $clone;
    //    }

    /**
     * @param bool $useSid
     * @return string
     */
    public function getUrl($useSid = true)
    {
        return $this->url->getPostUrl($this, $useSid);
    }

    /**
     * @return Author
     */
    public function getAuthor()
    {
        if (!$this->hasData('author')) {
            $this->setData('author', $this->authorRepository->get($this->getAuthorId()));
        }

        return $this->getData('author');
    }

    /**
     * @return string
     */
    public function getFeaturedImageUrl()
    {
        return $this->config->getMediaUrl($this->getFeaturedImage());
    }
}