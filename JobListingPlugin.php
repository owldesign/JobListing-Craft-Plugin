<?php

/*
Plugin Name: JobListing
Plugin Url: http://github.com/owldesign
Author: Vadim Goncharov (https://github.com/owldesign)
Author URI: http://owl-design.net
Description: Job listing plugin.
Version: 1.0
*/

namespace Craft;

class JobListingPlugin extends BasePlugin
{
	public function getName()
	{
	    return 'Job Listings';
	}

	public function getVersion()
	{
	    return '1.0';
	}

	public function getDeveloper()
	{
	    return 'Owl Design';
	}

	public function getDeveloperUrl()
	{
	    return 'http://owl-design.net';
	}

	public function hasCpSection()
	{
		return true;
	}

	public function registerCpRoutes()
	{
		return array(
			'joblisting/'                					=> array('action' => 'jobListing/listingIndex'),
			'joblisting/listing/(?P<entryId>\d+)' 	=> array('action' => 'jobListing/viewListing'),
		);
	}
}
