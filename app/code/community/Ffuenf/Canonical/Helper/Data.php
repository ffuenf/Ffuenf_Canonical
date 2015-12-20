<?php
/**
 * Ffuenf_Canonical extension.
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the MIT License
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/mit-license.php
 *
 * @category   Ffuenf
 *
 * @author     Achim Rosenhagen <a.rosenhagen@ffuenf.de>
 * @copyright  Copyright (c) 2015 ffuenf (http://www.ffuenf.de)
 * @license    http://opensource.org/licenses/mit-license.php MIT License
 */

class Ffuenf_Canonical_Helper_Data extends Ffuenf_Common_Helper_Core
{
    /**
     * config paths.
     */
    const CONFIG_EXTENSION_ACTIVE = 'ffuenf_canonical/general/enable';
    const CONFIG_EXTENSION_SCHEME = 'ffuenf_canonical/override/scheme';
    const CONFIG_EXTENSION_HOST = 'ffuenf_canonical/override/host';
    const XML_PATH_USE_CATEGORY_CANONICAL_TAG = 'catalog/seo/category_canonical_tag';
    const XML_PATH_USE_PRODUCT_CANONICAL_TAG = 'catalog/seo/product_canonical_tag';

    /**
     * Variable for if the extension is active.
     *
     * @var bool
     */
    protected $_bExtensionActive;

    /**
     * Variable for if canonical tag for category is active (magento default setting).
     *
     * @var bool
     */
    protected $_bCategoryCanonicalActive;

    /**
     * Variable for if canonical tag for product is active (magento default setting).
     *
     * @var bool
     */
    protected $_bProductCanonicalActive;

    /**
     * Check to see if the extension is active.
     *
     * @return bool
     */
    public function isExtensionActive()
    {
        if ($this->_bExtensionActive === null) {
            $this->_bExtensionActive = $this->getStoreFlag(self::CONFIG_EXTENSION_ACTIVE, '_bExtensionActive');
        }
        return $this->_bExtensionActive;
    }

    /**
     * Check to see if canonical tag for category is active (magento default setting).
     *
     * @return bool
     */
    public function isCategoryCanonicalActive()
    {
        if ($this->_bCategoryCanonicalActive === null) {
            $this->_bCategoryCanonicalActive = $this->getStoreFlag(self::XML_PATH_USE_CATEGORY_CANONICAL_TAG, '_bCategoryCanonicalActive');
        }
        return $this->_bCategoryCanonicalActive;
    }

    /**
     * Check to see if canonical tag for product is active (magento default setting).
     *
     * @return bool
     */
    public function isProductCanonicalActive()
    {
        if ($this->_bProductCanonicalActive === null) {
            $this->_bProductCanonicalActive = $this->getStoreFlag(self::XML_PATH_USE_PRODUCT_CANONICAL_TAG, '_bProductCanonicalActive');
        }
        return $this->_bProductCanonicalActive;
    }

    public function getHeadCanonicalUrl()
    {
        if (empty($this->_data['urlKey'])) {
            $url = Mage::helper('core/url')->getCurrentUrl();
            $parsedUrl = parse_url($url);
            $scheme = (Mage::getStoreConfig(self::CONFIG_EXTENSION_SCHEME) != '') ? Mage::getStoreConfig(self::CONFIG_EXTENSION_SCHEME) : $parsedUrl['scheme'];
            $host = (Mage::getStoreConfig(self::CONFIG_EXTENSION_HOST) != '') ? Mage::getStoreConfig(self::CONFIG_EXTENSION_HOST) : $parsedUrl['host'];
            $path = $parsedUrl['path'];
            $headUrl = $scheme . '://' . $host . $path;
            if (!preg_match('/\.(rss|html|htm|xml|php?)$/', strtolower($headUrl)) && substr($headUrl, -1) != '/') {
                $headUrl .= '/';
            }
            $this->_data['urlKey'] = $headUrl;
        }
        return $this->_data['urlKey'];
    }

    public function getHeadProductCanonicalUrl()
    {
        $product_id = Mage::app()->getRequest()->getParam('id');
        $_product = Mage::getModel('catalog/product')->load($product_id);
        $selected = $_product->getData('ffuenf_canonicalurl');
        $url = Mage::helper('core/url')->getCurrentUrl();
        $parsedUrl = parse_url($url);
        $scheme = (Mage::getStoreConfig(self::CONFIG_EXTENSION_SCHEME) != '') ? Mage::getStoreConfig(self::CONFIG_EXTENSION_SCHEME) : $parsedUrl['scheme'];
        $host = (Mage::getStoreConfig(self::CONFIG_EXTENSION_HOST) != '') ? Mage::getStoreConfig(self::CONFIG_EXTENSION_HOST) : $parsedUrl['host'];
        $baseUrl = $scheme . '://' . $host . '/';
        if ($selected != NULL) {
            if ($selected == 1) {
                $product_id = Mage::app()->getRequest()->getParam('id');
                $_item = Mage::getModel('catalog/product')->load($product_id);
                $this->_data['urlKey'] = $baseUrl.$_item->getUrlKey() . Mage::helper('catalog/product')->getProductUrlSuffix();
                if (!preg_match('/\.(rss|html|htm|xml|php?)$/', strtolower($this->_data['urlKey'])) && substr($this->_data['urlKey'], -1) != '/') {
                    $this->_data['urlKey'] .= '/';
                }
                return $this->_data['urlKey'];
            } else {
                return $baseUrl . $selected;
            }
        } else {
            if (empty($this->_data['urlKey'])) {
                $product_id = Mage::app()->getRequest()->getParam('id');
                $_item = Mage::getModel('catalog/product')->load($product_id);
                $this->_data['urlKey'] = $baseUrl.$_item->getUrlKey() . Mage::helper('catalog/product')->getProductUrlSuffix();
                if (!preg_match('/\.(rss|html|htm|xml|php?)$/', strtolower($this->_data['urlKey'])) && substr($this->_data['urlKey'], -1) != '/') {
                    $this->_data['urlKey'] .= '/';
                }
            }
            return $this->_data['urlKey'];
        }
    }
}
