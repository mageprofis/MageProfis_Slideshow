<?php

class MageProfis_Slideshow_Block_Adminhtml_Slideshow_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{

    protected function _prepareForm()
    {
        $form = new Varien_Data_Form();
        $this->setForm($form);
        $fieldset = $form->addFieldset('slideshow_form', array('legend' => Mage::helper('mp_slideshow')->__('General')));

        $fieldset->addField('title', 'text', array(
            'label'     => Mage::helper('mp_slideshow')->__('Title'),
            'class'     => 'required-entry',
            'required'  => true,
            'name'      => 'title',
        ));

        $fieldset->addField('group_name', 'text', array(
            'label'     => Mage::helper('mp_slideshow')->__('Group Name'),
            'note'      => Mage::helper('mp_slideshow')->__('Slides with the same group name will be shown in the same slider'),
            'class'     => 'required-entry',
            'required'  => true,
            'name'      => 'group_name',
        ));

        if (!Mage::app()->isSingleStoreMode()) {
            $fieldset->addField('store_id', 'multiselect', array(
                'name'      => 'store_id[]',
                'label'     => Mage::helper('mp_slideshow')->__('Select Store'),
                'title'     => Mage::helper('mp_slideshow')->__('Select Store'),
                'required'  => true,
                'values'    => Mage::getSingleton('adminhtml/system_store')->getStoreValuesForForm(false, true),
            ));
        } else {
            $fieldset->addField('store_id', 'hidden', array(
                'name'      => 'store_id[]',
                'value'     => Mage::app()->getStore(true)->getId()
            ));
        }

        $fieldset->addField('slide_url', 'text', array(
            'label'     => Mage::helper('mp_slideshow')->__('Url'),
            'required'  => false,
            'name'      => 'slide_url',
        ));

        $fieldset->addField('slide_target', 'select', array(
            'label'     => Mage::helper('mp_slideshow')->__('Target'),
            'name'      => 'slide_target',
            'values'    => array(
                array(
                    'value'     => '_blank',
                    'label'     => Mage::helper('mp_slideshow')->__('Blank'),
                ),
                array(
                    'value'     => '_new',
                    'label'     => Mage::helper('mp_slideshow')->__('New'),
                ),
                array(
                    'value'     => '_parent',
                    'label'     => Mage::helper('mp_slideshow')->__('Parent'),
                ),
                array(
                    'value'     => '_self',
                    'label'     => Mage::helper('mp_slideshow')->__('Self'),
                ),
                array(
                    'value'     => '_top',
                    'label'     => Mage::helper('mp_slideshow')->__('Top'),
                ),
            ),
        ));

        $fieldset->addField('filename', 'image', array(
            'label'     => Mage::helper('mp_slideshow')->__('Image File'),
            'required'  => true,
            'name'      => 'filename',
        ));

        $fieldset->addField('sort_order', 'text', array(
            'label'     => Mage::helper('mp_slideshow')->__('Sort Order'),
            'name'      => 'sort_order',
        ));

        $fieldset->addField('status', 'select', array(
            'label'     => Mage::helper('mp_slideshow')->__('Status'),
            'name'      => 'status',
            'values'    => array(
                array(
                    'value'     => 1,
                    'label'     => Mage::helper('mp_slideshow')->__('Active'),
                ),
                array(
                    'value'     => 0,
                    'label'     => Mage::helper('mp_slideshow')->__('Inactive'),
                ),
            ),
        ));
        
        $fieldset->addField('active_from', 'date', array(
            'label'     => Mage::helper('mp_slideshow')->__('Active from'),
            'name'      => 'active_from',
            'required'  => false,
            'format'    => Mage::app()->getLocale()->getDateTimeFormat(Mage_Core_Model_Locale::FORMAT_TYPE_SHORT),
            'image'     => $this->getSkinUrl('images/grid-cal.gif'),
            'time'      => true
        ));
        
        $fieldset->addField('active_to', 'date', array(
            'label'     => Mage::helper('mp_slideshow')->__('Active to'),
            'name'      => 'active_to',
            'required'  => false,
            'format'    => Mage::app()->getLocale()->getDateTimeFormat(Mage_Core_Model_Locale::FORMAT_TYPE_SHORT),
            'image'     => $this->getSkinUrl('images/grid-cal.gif'),
            'time'      => true
        ));
        
        Mage::dispatchEvent('mageprofis_slideshow_adminhtml_slideshow_edit_tab_form_prepare_form', array('form' => $form, 'fieldset' => $fieldset));

        if (Mage::getSingleton('adminhtml/session')->getSlideshowData()) {
            $form->setValues(Mage::getSingleton('adminhtml/session')->getSlideshowData());
            Mage::getSingleton('adminhtml/session')->setSlideshowData(null);
        } elseif (Mage::registry('slideshow_data')) {
            $form->setValues(Mage::registry('slideshow_data')->getData());
        }

        return parent::_prepareForm();
    }
}
