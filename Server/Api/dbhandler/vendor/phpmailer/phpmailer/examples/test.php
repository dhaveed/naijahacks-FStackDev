<?php 
	function mail_verification($email, $token) {
		require_once(dirname(__DIR__).'../PHPMailerAutoload.php');
		// TCP port to connect to
		$this->mail = new PHPMailer;
			//$mail->SMTPDebug = 3;                               // Enable verbose debug output
			$this->mail->isSMTP();                                      // Set mailer to use SMTP
			//add these codes if not written
			$this->mail->IsSMTP();
			$this->mail->SMTPAuth   = true;  
			$this->mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
			$this->mail->SMTPAuth = true;                               // Enable SMTP authentication
			$this->mail->Username = SMTP_USER;                 // SMTP username
			$this->mail->Password = SMTP_PASSWORD;                           // SMTP password
			$this->mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
			$this->mail->Port = 25;
			$this->mail->setFrom('cseweek@lmu.edu.ng', 'CSE Week Voting  - Verification Email');
			
			$this->mail->addAddress($email, ''); 
       // Add attachments
			    // Optional name
			$this->mail->isHTML(true);                                  // Set email format to HTML

			$this->mail->Subject = 'CSE Week Voting 2018';
			$this->mail->From = "csevote@lmu.edu.ng";
			$this->mail->FromName = "College Of Science and Engineering";
			$this->mail->Subject = "Password Token";
			$msg = '<html>
					  <head>
					    <title>Activation Email</title>
					  </head>
					  <body>  
					    <div id="" style="display: block;" class="rl-cache-class b-text-part html">
					      <div data-x-div-type="html">
					        <div data-x-div-type="body" style="-webkit-text-size-adjust: none;-ms-text-size-adjust: 100%;background-color: #F3F3F3">
					          <table cellspacing="0" cellpadding="0" border="0" width="100%">
					            <tbody>
					              <tr> 
					                <td style="background-color: #F3F3F3" align="center" valign="top"> 
					                  <table cellspacing="0" cellpadding="0" border="0" width="580"> 
					                    <tbody>
					                      <tr>
					                        
					                      </tr> 
					                      <tr> 
					                        <td style="font-family: "Helvetica Neue",Helvetica,Arial,sans-serif;font-size: 15px;line-height: 19px;font-weight: bold;background-color: #FFFFFF" align="center" width="580"> 
					                          <div>
					                            <div>
					                              <a style="outline: none" target="_blank" tabindex="-1"></a>
					                            </div>
					                          </div> 
					                        </td> 
					                      </tr> 
					                      <tr> 
					                        <td style="padding-top: 30px;padding-right: 40px;padding-bottom: 30px;padding-left: 40px;background-color: #FFFFFF" align="center" width="580"> 
					                          <table cellspacing="0" margin cellpadding="0" border="0" width="580"> 
					                            <tbody>
					                              <tr>
					                              </tr> 
					                              <tr> 
					                                <td style="font-family: "Helvetica Neue",Helvetica,Arial,sans-serif;font-size: 15px;line-height: 19px;font-weight: bold;background-color: #FFFFFF" align="center" width="580"> 
					                                  <div>
					                                    <div>
					                                      <a style="outline: none" target="_blank" tabindex="-1">
					                                      </a>
					                                    </div>
					                                  </div> 
					                                </td> 
					                              </tr> 
					                              <tr> 
					                                <td style="padding-top: 30px;padding-right: 40px;padding-bottom: 30px;padding-left: 40px;background-color: #FFFFFF" align="center" width="580"> 
					                                  <table cellspacing="0" cellpadding="0" border="0"> 
					                                    <tbody>
					                                      <tr> 
					                                        <td style="font-family: "Helvetica Neue",Helvetica,Arial,sans-serif;font-size: 23px;line-height: 28px"> 
					                                          <div style="font-size: 23px;color: #313131;font-weight: bold;text-decoration: none">
					                                            <div style="text-align: center">
					                                              <strong>Welcome to CSE Voting Site</strong>
					                                            </div>
					                                          </div> 
					                                        </td> 
					                                      </tr> 
					                                      <tr> 
					                                        <td style="font-size: 10px;line-height: 10px">
					                                          <img alt="" style="display: block" data-x-broken-src="../images/gif.gif" height="10" width="1">
					                                        </td> 
					                                      </tr> 
					                                      <tr> 
					                                        <td style="font-family: "Helvetica Neue",Helvetica,Arial,sans-serif;font-size: 15px;line-height: 19px;color: #2e2e31" align="left"> 
					                                          <div> 
					                                            <div> 
					                                            </div> 
					                                            <div style="text-align: center">Your login password  is 
					                                              <h3> ' . $token . '</h3>. 
					                                              <center>This is an automated message. Do not reply.</center><br> 
					                                              <center><h4>Just a reminder you have no choice</h4></center> 
					                                            </div> 
					                                          </div> 
					                                        </td> 
					                                      </tr> 
					                                      <tr> 
					                                        <td height="30">
					                                          <img alt="" style="display: block" data-x-broken-src="../images/gif.gif" height="30" width="1">
					                                        </td> 
					                                      </tr> 
					                                      <tr> 
					                                        <td style="font-family: "Helvetica Neue",Helvetica,Arial,sans-serif;font-size: 15px;font-weight: bold" align="center"> 
					                                          <div> 
					                                            <div>
					                                              <a style="background-color: #800000;border-radius: 2px;color: #ffffff;display: inline-block;line-height: 40px;text-align: center;text-decoration: none;width: 160px;-webkit-text-size-adjust: none" href="http://csevote.lmu.edu.ng" target="_blank" rel="external nofollow noopener noreferrer" tabindex="-1">Back to Site!
					                                              </a>
					                                            </div> 
					                                            <div> 
					                                            </div> 
					                                          </div> 
					                                        </td> 
					                                      </tr> 
					                                    </tbody>
					                                  </table> 
					                                </td> 
					                              </tr> 
					                              <tr> 
					                                <td style="font-family: "Helvetica Neue",Helvetica,Arial,sans-serif;font-size: 15px;line-height: 19px;font-weight: bold;background-color: #FFFFFF" align="center" width="580"> 
					                                  <div>
					                                    
					                                  </div> 
					                                </td> 
					                              </tr> 
					                              <tr> 
					                                <td style="background-color: #4C4C4C"> 
					                                  <table style="background-color: #4C4C4C" cellspacing="0" cellpadding="0" border="0" align="center">
					                                    <tbody>
					                                      <tr> 
					                                        <td width="15">
					                                          <img alt="" style="display: block" data-x-broken-src="../images/gif.gif" height="1" width="15"></td> 
					                                        <td width="279">
					                                        <img alt="" style="display: block" data-x-broken-src="../images/gif.gif" height="1" width="279"></td> 
					                                      </tr>
					                                    </tbody>
					                                  </table> 
					                                </td> 
					                              </tr> 
					                              <tr> 
					                                <td style="padding-top: 30px;padding-right: 30px;padding-bottom: 30px;padding-left: 30px"> 
					                                  <table cellspacing="0" cellpadding="0" border="0" align="center"> 
					                                    <tbody>
					                                      <tr> 
					                                        <td style="font-family: "Helvetica Neue", Arial, Helvetica, sans-serif;color: #808285;font-size: 13px;line-height: 19px;font-weight: bold" align="center" valign="top">
					                                          <a href="http://CSEVOTE.LMU.EDU.NG" target="_blank" style="color: #808285;text-decoration: none" rel="external nofollow noopener noreferrer" tabindex="-1">CSE DEV COMMITY</a>
					                                        </td> 
					                                      </tr> 
					                                    </tbody>
					                                  </table> 
					                                </td> 
					                              </tr> 
					                            </tbody>
					                          </table>
					                        </td>
					                      </tr>
					                    </tbody>
					                  </table>
					                </td>
					              </tr>
					            </tbody>
					          </table>
					        </div>
					      </div>
					    </div>';
			
			// echo $this->mail->Body;
			$this->mail->Body = $msg;
			$this->mail->IsHTML(true);

			if(!$this->mail->send()) {
			    return false;
			} else {
			    return true;
			}

	}

?>