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
    $variables['listings'] = craft()->jobListing->getAllListings();
    $this->renderTemplate('joblisting/index', $variables);
  }


  /**
  * View Listings in CP.
  *
  * @param array $variables
  * @throws HttpException
  */
  public function actionViewListing(array $variables = array())
  {
    $entry              = craft()->jobListing->getFormEntryById($variables['entryId']);
    $variables['entry'] = $entry;

    if (empty($entry)) { throw new HttpException(404); }

    $this->renderTemplate('joblisting/_view', $variables);
  }


  /**
  * Save Listing from front-end.
  *
  * @throws HttpException
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

    // File Upload
    $uploadedFile = UploadedFile::getInstanceByName('company_logo');
    if ($uploadedFile) {
      $folderId = 1;
      $fileName = $uploadedFile->name;
      $fileLocation = AssetsHelper::getTempFilePath(pathinfo($fileName, PATHINFO_EXTENSION));
      move_uploaded_file($uploadedFile->tempName, $fileLocation);
      $extension = IOHelper::getExtension($fileLocation);
      if (!IOHelper::isExtensionAllowed($extension)) {
        craft()->userSession->setNotice(Craft::t("Uploaded file not allowed."));
        $this->redirectToPostedUrl();
      }
      $response = craft()->assets->insertFileByLocalPath($fileLocation, $fileName, $folderId, AssetConflictResolution::KeepBoth);
      if ($response->isSuccess()) {
        $fieldId = $response->getDataItem('fileId');
      }
    } else {
      $fieldId = null;
      $fileName = null;
    }

    // Create new listing
    $form = new JobListingModel;

    $form->title              = craft()->request->getPost('title');
    $form->description        = craft()->request->getPost('description');
    $form->type               = craft()->request->getPost('type');
    $form->location           = craft()->request->getPost('location');
    $form->company_name       = craft()->request->getPost('company_name');
    $form->company_website    = craft()->request->getPost('company_website');
    $form->company_logo       = $fileName;
    $form->application_url    = craft()->request->getPost('application_url');
    $form->listing_date       = craft()->request->getPost('listing_date');
    $form->expiration_date    = craft()->request->getPost('expiration_date');



    if ($form->validate()) {
      if (craft()->jobListing->saveListing($form)) {
        craft()->userSession->setNotice(Craft::t('Listing Submitted.'));
        $this->redirectToPostedUrl();
      }
    } else {
      craft()->userSession->setNotice(Craft::t("Couldn't submit."));
      craft()->urlManager->setRouteVariables(array(
        'listing' => $form
      ));
    }

  }


  /**
  * Delete Listings from CP.
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
