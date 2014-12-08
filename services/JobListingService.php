<?php
namespace Craft;

class JobListingService extends BaseApplicationComponent
{

  /**
   * 
   * Gell All Listings
   * 
   */
  public function getAllListings()
  {
    $listings = JobListingRecord::model()->findAll();
    return $listings;
  }


  /**
   * 
   * Save Listing Entry
   * 
   */
  public function saveListing(JobListingModel $form)
  {
    $listingRecord = new JobListingRecord();

    // Set attributes
    $listingRecord->title             = $form->title;
    $listingRecord->description       = $form->description;
    $listingRecord->type              = $form->type;
    $listingRecord->location          = $form->location;
    $listingRecord->company_name      = $form->company_name;
    $listingRecord->company_website   = $form->company_website;
    $listingRecord->company_logo      = $form->company_logo;
    $listingRecord->application_url   = $form->application_url;
    $listingRecord->listing_date      = $form->listing_date;
    $listingRecord->expiration_date   = $form->expiration_date;

    // Validate listing against JobListingRecord
    $listingRecord->validate();
    // Add erros
    $form->addErrors($listingRecord->getErrors());
    if (!$form->hasErrors()) {
      $transaction = craft()->db->getCurrentTransaction() === null ? craft()->db->beginTransaction() : null;
      
      try {
        $formRecord->save(false);
        
        if (!$form->id) {
          $form->id = $formRecord->id;
        } 

        if ($transaction !== null) {
          $transaction->commit();
        }
      } catch (\Exception $e) {
        if ($transaction !== null) {
          $transaction->rollback();
        }
        throw $e;
      }
      return true;
    } else {
      return false;
    }
  }

}