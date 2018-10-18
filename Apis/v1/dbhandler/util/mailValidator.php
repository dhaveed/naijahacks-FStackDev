<?php
  class Validator {
    private $accepted_domains;
    
    public function __construct() {
      $this->accepted_domains = array(
        'lmu.edu.ng', 'gmail.com', 'yahoo.com');
    }
    
    public function validate_by_domain($email_address) {
      if($email_address == "std@lmu.edu.ng") {
        return false;
      }
      $domain = $this->get_domain( trim( $email_address ) );
      if ( in_array( $domain, $this->accepted_domains ) ) {
        return true;
      }
      return false;
    }

    private function get_domain($email_address) {
      if ( ! $this->is_email( $email_address ) ) {
        return false;
      }
      $email_parts = explode( '@', $email_address );
      
      $domain = array_pop( $email_parts );
      return $domain;
    }
    
    private function is_email($email_address) {
      if ( filter_var ( $email_address, FILTER_VALIDATE_EMAIL ) ) {
        return true;
      }
      
      return false;
    }
  }
?>