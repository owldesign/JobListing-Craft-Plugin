<?php
namespace Craft;

class JobListingModel extends BaseElementModel
{

  protected $elementType = 'JobListing';

  function __toString()
  {
    return Craft::t($this->id);
  }

  /**
   * @access protected
   * @return array
   */
  protected function defineAttributes()
  {
    return array_merge(parent::defineAttributes(), array(
      'title'             => array(AttributeType::Name, 'required' => true),
      'description'       => array(AttributeType::Name, 'required' => true),
      'type'              => AttributeType::Name,
      'location'          => AttributeType::Name,
      'company_name'      => AttributeType::Name,
      'company_website'   => AttributeType::Url,
      'company_logo'      => AttributeType::Mixed,
      'application_url'   => AttributeType::Url,
      'listing_date'      => AttributeType::Mixed,
      'expiration_date'   => AttributeType::Mixed,
    ));
  }

  /**
   * Returns whether the current user can edit the element.
   *
   * @return bool
   */
  public function isEditable()
  {
    return true;
  }

  /**
   * Returns the element's CP edit URL.
   *
   * @return string|false
   */
  public function getCpEditUrl()
  {
    return UrlHelper::getCpUrl('joblisting/entries/'.$this->id);
  }

}