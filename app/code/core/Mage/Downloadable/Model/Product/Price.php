<?php
/**
 * Magento Enterprise Edition
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Magento Enterprise Edition End User License Agreement
 * that is bundled with this package in the file LICENSE_EE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.magento.com/license/enterprise-edition
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magento.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magento.com for more information.
 *
 * @category    Mage
 * @package     Mage_Downloadable
 * @copyright Copyright (c) 2006-2015 X.commerce, Inc. (http://www.magento.com)
 * @license http://www.magento.com/license/enterprise-edition
 */

/**
 * Downloadable products price model
 *
 * @category    Mage
 * @package     Mage_Downloadable
 * @author      Magento Core Team <core@magentocommerce.com>
 */
class Mage_Downloadable_Model_Product_Price extends Mage_Catalog_Model_Product_Type_Price
{
    /**
     * Retrieve product final price
     *
     * @param integer $qty
     * @param Mage_Catalog_Model_Product $product
     * @return float
     */
    public function getFinalPrice($qty=null, $product)
    {
        if (is_null($qty) && !is_null($product->getCalculatedFinalPrice())) {
            return $product->getCalculatedFinalPrice();
        }

        $finalPrice = parent::getFinalPrice($qty, $product);

        /**
         * links prices are added to base product price only if they can be purchased separately
         */
        if ($product->getLinksPurchasedSeparately()) {
            if ($linksIds = $product->getCustomOption('downloadable_link_ids')) {
                $linkPrice = 0;
                $links = $product->getTypeInstance(true)
                    ->getLinks($product);
                foreach (explode(',', $linksIds->getValue()) as $linkId) {
                    if (isset($links[$linkId])) {
                        $linkPrice += $links[$linkId]->getPrice();
                    }
                }
                $finalPrice += $linkPrice;
            }
        }

        $product->setData('final_price', $finalPrice);
        return max(0, $product->getData('final_price'));
    }
}