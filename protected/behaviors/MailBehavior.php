<?php  
// MailBehavior extends from CBehavior
class MailBehavior extends CBehavior
{
    public function sendMail($message, $subject, $to, $attachments = null)
    {
        Yii::import('application.extensions.phpmailer.JPhpMailer');
        try{
            $mail = new JPhpMailer;
            $mail->IsSMTP();
            $mail->Mailer = "smtp";
            $mail->SMTPAuth = true;
            $mail->Host = Yii::app()->params['host_email'];
            $mail->Port = 25;
            $mail->Username = Yii::app()->params['info_email_account'];
            $mail->Password = Yii::app()->params['info_email_password'];
            $mail->CharSet = "UTF-8";
            $mail->SetFrom(Yii::app()->params['info_email_account'], Yii::t('app','Web Programming'));
            $mail->Subject = $subject;
            $mail->AltBody = 'To view the message, please use an HTML compatible email viewer!';
            $mail->MsgHTML($message);
            $mail->AddAddress($to);
            if ($attachments != null){
                foreach ($attachments as $e) {
                    $mail->AddAttachment($e);
                }
            }
        }catch (Exception $e){
            echo $e->getTraceAsString();
        }
        return false;
    }
}
?>