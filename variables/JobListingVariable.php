<?php
namespace Craft;

class JobListingVariable
{

  function getAllListings()
  {
    return craft()->jobListing->getAllListings();
  }

  function getJobBySlug($slug)
  {
    return craft()->jobListing->getJobBySlug($slug);
  }
}