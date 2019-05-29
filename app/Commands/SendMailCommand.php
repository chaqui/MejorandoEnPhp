<?php
namespace app\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use app\Models\MessageModel;

class SendMailCommand extends Command
{
  protected static $defaultName = 'app:SenMail';


  public function execute(InputInterface $input, OutputInterface $output)
  {
      $pendingMessage = MessageModel::where('send',false)->first();
      // Create the Transport
      if($pendingMessage){
        $transport = (new \Swift_SmtpTransport(getenv("SMTP_HOST"), getenv('SMTP_PORT')))
        ->setUsername(getenv('SMTP_USER'))
        ->setPassword(getenv('SMTP_PASS'));

        // Create the Mailer using your created Transport
        $mailer = new \Swift_Mailer($transport);

        // Create a message
        $message = (new \Swift_Message('Wonderful Subject'))
        ->setFrom(['contact@mail.com' => 'John Doe'])
        ->setTo(['receiver@domain.org', 'other@domain.org' => 'A name'])
        ->setBody('Hi, you have a message. Name: '.$pendingMessage->name." Email:".$pendingMessage->email. ' Message: '.$pendingMessage->message);

        // Send the message
        $result = $mailer->send($message);
        $pendingMessage->send =true;
        $pendingMessage->save();
      }
  }
}