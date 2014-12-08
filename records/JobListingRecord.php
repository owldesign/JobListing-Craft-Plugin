<?php
namespace Craft;

class JobListingRecord extends BaseRecord
{
  public function getTableName()
  {
    return 'joblisting';
  }

  public function defineAttributes()
  {
    return array(
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
    );
  }

}