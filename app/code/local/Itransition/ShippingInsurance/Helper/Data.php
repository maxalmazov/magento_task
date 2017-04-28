<?php
/**
 * Sample Widget Helper
 */
class Itransition_ShippingInsurance_Helper_Data extends Mage_Core_Helper_Abstract
{
    public function rewriteTotals($class)
    {
        $order = $class->getOrder();
        $label = Mage::getStoreConfig('shippinginsurance_setting/shippinginsurance_group/shippinginsurance_label');

        if ($order->getInsuranceShippingMethod()) {
            $costInsurance = $order->getShippingInsurance();
            $class->addTotalBefore(
                new Varien_Object(
                    [
                        'code' => $class->getCode(),
                        'value' => $costInsurance,
                        'base_value' => $costInsurance,
                        'label' => $label
                    ],
                    'grand_total'
                )
            );
        }
    }
}