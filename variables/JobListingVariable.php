<?php
namespace Craft;

class JobListingVariable
{
  function listings()
  {
    return craft()->elements->getCriteria('JobListing');
  }
}