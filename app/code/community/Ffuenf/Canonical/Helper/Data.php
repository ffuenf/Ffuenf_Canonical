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

class Ffuenf_Canonical_Helper_Data extends Ffuenf_Canonical_Helper_Core
{

    /**
     * config paths.
     */
    const CONFIG_EXTENSION_ACTIVE = 'canonical/enable';

    /**
     * Variable for if the extension is active.
     *
     * @var bool
     */
    protected $bExtensionActive;

    /**
     * Check to see if the extension is active.
     *
     * @return bool
     */
    public function isExtensionActive()
    {
        if ($this->bExtensionActive === null) {
            $this->bExtensionActive = $this->getStoreFlag(self::CONFIG_EXTENSION_ACTIVE, 'bExtensionActive');
        }
        return $this->bExtensionActive;
    }

    public function getHeadCanonicalUrl()
    {
        if (empty($this->_data['urlKey'])) {
            $url = Mage::helper('core/url')->getCurrentUrl();
            $parsedUrl = parse_url($url);
            $scheme = $parsedUrl['scheme'];
            $host = $parsedUrl['host'];
            $port = isset($parsedUrl['port']) ? $parsedUrl['port'] : null;
            $path = $parsedUrl['path'];
            $headUrl = $scheme . '://' . $host . ($port && '80' != $port ? ':' . $port : '') . $path;
            if (!preg_match('/\.(rss|html|htm|xml|php?)$/', strtolower($headUrl)) && substr($headUrl, -1) != '/') {
                $headUrl .= '/';
            }
            $this->_data['urlKey'] =$headUrl;
        }
        return $this->_data['urlKey'];
    }

    public function getHeadProductCanonicalUrl()
    {
        $product_id =  Mage::app()->getRequest()->getParam('id');
        $_product = Mage::getModel('catalog/product')->load($product_id);
        $selected = $_product->getData('ffuenf_canonicalurl');
        if ($selected != NULL) {
            if ($selected == 1) {
                $product_id =  Mage::app()->getRequest()->getParam('id');
                $_item = Mage::getModel('catalog/product')->load($product_id);
                $this->_data['urlKey'] = Mage::getBaseUrl().$_item->getUrlKey().Mage::helper('catalog/product')->getProductUrlSuffix();
                if (!preg_match('/\.(rss|html|htm|xml|php?)$/', strtolower($this->_data['urlKey'])) && substr($this->_data['urlKey'], -1) != '/') {
                    $this->_data['urlKey'] .= '/';
                }
                return $this->_data['urlKey'];
            } else {
                $base_url = Mage::getBaseUrl();
                return $base_url . $selected;
            }
        } else {
            if (empty($this->_data['urlKey'])) {
                $product_id =  Mage::app()->getRequest()->getParam('id');
                $_item = Mage::getModel('catalog/product')->load($product_id);
                $this->_data['urlKey'] = Mage::getBaseUrl().$_item->getUrlKey().Mage::helper('catalog/product')->getProductUrlSuffix();
                if (!preg_match('/\.(rss|html|htm|xml|php?)$/', strtolower($this->_data['urlKey'])) && substr($this->_data['urlKey'], -1) != '/') {
                    $this->_data['urlKey'] .= '/';
                }
            }
            return $this->_data['urlKey'];
        }
    }
}