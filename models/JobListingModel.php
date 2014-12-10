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
      'title'             => array(AttributeType::String, 'required' => true),
      'description'       => array(AttributeType::String, 'required' => true),
      'type'              => AttributeType::String,
      'location'          => AttributeType::String,
      'company_name'      => AttributeType::String,
      'company_website'   => AttributeType::Url,
      'company_logo'      => AttributeType::String,
      'application_url'   => AttributeType::Url,
      'listing_date'      => AttributeType::DateTime,
      'expiration_date'   => AttributeType::DateTime,
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