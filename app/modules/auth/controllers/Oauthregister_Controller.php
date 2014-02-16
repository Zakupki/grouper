<?php

require_once 'modules/base/controllers/Base_Controller.php';

Class Oauthregister Extends Base_Controller {
		
		function indexAction() {
			// The currently logged on user
			$user_id = 1;
			
			// This should come from a form filled in by the requesting user
			$consumer = array(
			    // These two are required
			    'requester_name' => 'John Doe',
			    'requester_email' => 'john@example.com',
			
			    // These are all optional
			    'callback_uri' => 'http://www.myconsumersite.com/oauth_callback',
			    'application_uri' => 'http://www.myconsumersite.com/',
			    'application_title' => 'John Doe\'s consumer site',
			    'application_descr' => 'Make nice graphs of all your data',
			    'application_notes' => 'Bladibla',
			    'application_type' => 'website',
			    'application_commercial' => 0
			);
			
			// Register the consumer
			$store = OAuthStore::instance(); 
			$key   = $store->updateConsumer($consumer, $user_id);
			
			// Get the complete consumer from the store
			$consumer = $store->getConsumer($key);
			
			// Some interesting fields, the user will need the key and secret
			$consumer_id = $consumer['id'];
			$consumer_key = $consumer['consumer_key'];
			$consumer_secret = $consumer['consumer_secret'];
        }
}


?>