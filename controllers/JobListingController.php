<?php
namespace Craft;

class JobListingController extends BaseController
{
  
  protected $allowAnonymous = true;


  /**
   * View Form Entry
   */
  public function actionListingIndex()
  {
    // Get the data
    $variables['listings'] = craft()->jobListing->getAllListings();
    // Render the template!
    $this->renderTemplate('joblisting/index', $variables);
  }



  public function actionViewListing(array $variables = array())
  {
    $entry              = craft()->jobListing->getFormEntryById($variables['entryId']);
    $variables['entry'] = $entry;

    if (empty($entry)) { throw new HttpException(404); }

    $this->renderTemplate('joblisting/_view', $variables);
  }


  /**
   * Save Form Entry
   */
  public function actionSaveListing()
  {
    // Require a post request
    $this->requirePostRequest();

    // Honeypot validation
    $honeypot = craft()->request->getPost('formHoneypot');
    if ($honeypot) { throw new HttpException(404); }

    // Get form handle
    $formBuilderHandle = craft()->request->getPost('jobListingHandle');
    if (!$formBuilderHandle) { throw new HttpException(404);}

    // Create new listing
    $form = new JobListingModel;


    $form->title              = craft()->request->getPost('title');
    $form->description        = craft()->request->getPost('description');
    $form->type               = craft()->request->getPost('type');
    $form->location           = craft()->request->getPost('location');
    $form->company_name       = craft()->request->getPost('company_name');
    $form->company_website    = craft()->request->getPost('company_website');
    $form->company_logo       = craft()->request->getPost('company_logo');
    $form->application_url    = craft()->request->getPost('application_url');
    $form->listing_date       = craft()->request->getPost('listing_date');
    $form->expiration_date    = craft()->request->getPost('expiration_date');



    if ($form->validate())
    {
        // It validates!
      echo 'valid';
    }
    else
    {
      craft()->userSession->setNotice(Craft::t("Couldn't submit."));
      // Send the saved form back to the template
      craft()->urlManager->setRouteVariables(array(
        'listing' => $form
      ));
    }


    // if (craft()->jobListing->saveListing($form)) {
    //   craft()->userSession->setNotice(Craft::t('Listing Submitted.'));
    //   $this->redirectToPostedUrl();
    // } else {
    //   craft()->userSession->setNotice(Craft::t("Couldn't submit."));
    //   // Send the saved form back to the template
    //   craft()->urlManager->setRouteVariables(array(
    //     'listing' => $form
    //   ));
      
    // }
    



    // // Form data
    // $data = serialize(craft()->request->getPost());

    // // New form entry model
    // $formBuilderEntry = new FormBuilder_EntryModel();

    // // Set entry attributes
    // $formBuilderEntry->formId   = $form->id;
    // $formBuilderEntry->title    = $form->name;
    // $formBuilderEntry->data     = $data;

    // // Save it
    // if (craft()->jobListing->saveFormEntry($formBuilderEntry)) {
    //   // Time to make the notifications
    //   if ($this->_sendEmailNotification($formBuilderEntry, $form)) {
    //     // Set the message
    //     if (!empty($form->successMessage)) {
    //       $message = $form->successMessage;
    //     } else {
    //       $message =  Craft::t('Thank you, we have received your submission and we\'ll be in touch shortly.');
    //     }
    //     craft()->userSession->setFlash('success', $message);
    //     $this->redirectToPostedUrl();
    //   } else {
    //     craft()->userSession->setError(Craft::t('We\'re sorry, but something has gone wrong.'));
    //   }
    //   craft()->userSession->setNotice(Craft::t('Entry saved.'));
    //   $this->redirectToPostedUrl($formBuilderEntry);
    // } else {
    //   craft()->userSession->setNotice(Craft::t("Couldn't save the form."));
    // }

    // // Send the saved form back to the template
    // craft()->urlManager->setRouteVariables(array(
    //   'entry' => $formBuilderEntry
    // ));
  }

  /**
   * Delete Entry
   */
  public function actionDeleteEntry()
  {
    $this->requirePostRequest();

    $entryId = craft()->request->getRequiredPost('entryId');

    if (craft()->elements->deleteElementById($entryId)) {
      craft()->userSession->setNotice(Craft::t('Entry deleted.'));
      $this->redirectToPostedUrl();
      craft()->userSession->setError(Craft::t('Couldn’t delete entry.'));
    }

  }

  protected function _filterPostKeys($post)
  {
    $filterKeys = array(
      'action',
      'redirect',
      'formhandle',
      'honeypot',
      'required',
    );
    if (isset($post['honeypot'])) {
      $honeypot = $post['honeypot'];
      array_push($filterKeys, $honeypot);
    }
    if (is_array($post)) {
      foreach ($post as $k => $v) {
        if (in_array(strtolower($k), $filterKeys)) {
          unset($post[$k]);
        }
      }
    }
    return $post;
  }

}
