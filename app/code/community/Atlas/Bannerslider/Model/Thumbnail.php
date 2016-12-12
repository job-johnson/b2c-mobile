<?php

/**
 * Atlas Extensions
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Atlas Commercial License
 * that is available through the world-wide-web at this URL:
 *
 * @copyright   Copyright (c) 2015 Atlas Extensions
 * @license     Commercial
 */
class Atlas_Bannerslider_Model_Thumbnail
{

    public function toOptionArray()
    {
        return array(
            array('value' => 1, 'label' => 'Yes'),
            array('value' => 0, 'label' => 'No'),
        );
    }

}

?>