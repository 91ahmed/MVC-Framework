<?php
	
	namespace System\Mail_SwiftMailer;

	class Mail_SwiftMailer
	{
		public $error;

		private $host 		= MAIL_HOST;
		private $port       = MAIL_PORT;
		private $encryption = MAIL_ENCRYPTION;
		private $username 	= MAIL_USERNAME;
		private $password 	= MAIL_PASSWORD;

		public $fromName;
		public $fromAddress;

		public $toAddress;
		public $toName;

		public $subject;
		public $message;


		public function SendMail ()
		{
			try
			{
				$this->SwiftMailer();
			} 
			catch (\Exception $e) 
			{
				$this->error = $e->getMessage();
			}
		}

		private function SwiftMailer ()
		{
			// Create the SMTP Transport
			$transport = (new \Swift_SmtpTransport($this->host, $this->port, $this->encryption))
				->setUsername($this->username)
				->setPassword($this->password);
		 
			// Create the Mailer using your created Transport
			$mailer = new \Swift_Mailer($transport);
		 
			// Create a message
			$message = new \Swift_Message();
		 
			// Set a "subject"
			$message->setSubject($this->subject);
		 
			// Set the "From address"
			$message->setFrom([$this->fromAddress => $this->fromName]);
		 
			// Set the "To address" [Use setTo method for multiple recipients, argument should be array]
			$message->addTo($this->toAddress, $this->toName);
		 
			// Add "CC" address [Use setCc method for multiple recipients, argument should be array]
			$message->addCc('recipient@gmail.com', 'recipient name');
		 
			// Add "BCC" address [Use setBcc method for multiple recipients, argument should be array]
			$message->addBcc('recipient@gmail.com', 'recipient name');
		 
			// Add an "Attachment" (Also, the dynamic data can be attached)
			//$attachment = Swift_Attachment::fromPath('example.xls');
			//$attachment->setFilename('report.xls');
			//$message->attach($attachment);
		 
			// Add inline "Image"
			//$inline_attachment = Swift_Image::fromPath('nature.jpg');
			//$cid = $message->embed($inline_attachment);
		 
			// Set the plain-text "Body"
			$message->setBody("This is the plain text body of the message.\nThanks,\nAdmin");
		 
			// Set a "Body"
			$message->addPart($this->message, 'text/html');
		 
			// Send the message
			$result = $mailer->send($message);
		}
	}
?>