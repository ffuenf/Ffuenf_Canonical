<?php
/**
 * Ffuenf_Pagespeed extension.
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
$installer = Mage::getResourceModel('catalog/setup','catalog_setup');
$conn = $installer->getConnection();

$installer->startSetup();
$installer->addAttribute('catalog_product', 'ffuenf_canonicalurl', array(
    'label'         => 'Canonical Url',
    'input'         => 'select',
    'type'          => 'varchar',
    'class'         => '',
    'global'        => true,
    'visible'       => true,
    'required'      => false,
    'user_defined'  => false,
    'default'       => '',
    'apply_to'      => 'simple,configurable,bundle,grouped',
    'option' => array(
        'value' => array( 
            'optionone' => array('Config'),
        )
    ),
    'visible_on_front' => true,
    'is_configurable' => false,
    'wysiwyg_enabled' => false,
    'used_in_product_listing' => true,
    'is_html_allowed_on_front' => true,
    'group'         => 'Meta Information',
    'sort_order'    => '84',
));
$installer->endSetup();
