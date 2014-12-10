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
      'title'             => array(AttributeType::String, 'required' => true),
      'description'       => array(AttributeType::String, 'required' => true),
      'type'              => AttributeType::String,
      'location'          => AttributeType::String,
      'company_name'      => AttributeType::String,
      'company_website'   => AttributeType::Url,
      'company_logo'      => AttributeType::String,
      'application_url'   => AttributeType::Url,
      'listing_date'      => AttributeType::Name,
      'expiration_date'   => AttributeType::Name,
    );
  }

}