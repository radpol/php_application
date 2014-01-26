<?php
class SimpleMail
{
  // Vlastnosti t��dy - polo�ky zpr�vy.
  private $toAddress;
  private $CCAddress;
  private $BCCAddress;
  private $fromAddress;
  private $subject;
  private $sendText;
  private $textBody;
  private $sendHTML;
  private $HTMLBody;

  // Inicializace polo�ek zpr�vy pr�zdn�mi nebo implicitn�mi hodnotami.
  public function __construct() {
    $this->toAddress = '';
    $this->CCAddress = '';
    $this->BCCAddress = '';
    $this->fromAddress = '';
    $this->subject = '';
    $this->sendText = true;
    $this->textBody = '';
    $this->sendHTML = false;
    $this->HTMLBody = '';
  }

  // Nastaven� adresy p��jemce.
  public function setToAddress($value) {
    $this->toAddress = $value;
  }

  // Nastaven� adresy p��jemce kopie.
  public function setCCAddress($value) {
    $this->CCAddress = $value;
  }

  // Nastaven� adresy p��jemce skryt� kopie.
  public function setBCCAddress($value) {
    $this->BCCAddress = $value;
  }

  // Nastaven� adresy odes�latele.
  public function setFromAddress($value) {
    $this->fromAddress = $value;
  }

  // Nastaven� p�edm�tu zpr�vy.
  public function setSubject($value) {
    $this->subject = $value;
  }

  // Nastaven�, zda m� b�t zpr�va odesl�na jako prost� text.
  public function setSendText($value) {
    $this->sendText = $value;
  }

  // Nastaven� t�la textov� zpr�vy.
  public function setTextBody($value) {
    $this->sendText = true;
    $this->textBody = $value;
  }

  // Nastaven�, zda m� b�t zpr�va odesl�na ve form�tu HTML.
  public function setSendHTML($value) {
    $this->sendHTML = $value;
  }

  // Nastaven� t�la zpr�vy ve form�tu HTML.
  public function setHTMLBody($value) {
    $this->sendHTML = true;
    $this->HTMLBody = $value;
  }

  // Odesl�n� zpr�vy.
  public function send($to = null, $subject = null, $message = null,
    $headers = null) {

    $success = false;
    if (!is_null($to) && !is_null($subject) && !is_null($message)) {
      $success = mail($to, $subject, $message, $headers);
      return $success;
    } else {
      $headers = array();
      if (!empty($this->fromAddress)) {
        $headers[] = 'From: ' . $this->fromAddress;
      }

      if (!empty($this->CCAddress)) {
        $headers[] = 'CC: ' . $this->CCAddress;
      }

      if (!empty($this->BCCAddress)) {
        $headers[] = 'BCC: ' . $this->BCCAddress;
      }

      if ($this->sendText && !$this->sendHTML) {
        $headers[] = 'MIME-Version: 1.0';
        $headers[] = 'Content-type: text/plain; charset="windows-1250"';
        $headers[] = 'Content-Transfer-Encoding: 7bit';
        $message = $this->textBody;
      } elseif (!$this->sendText && $this->sendHTML) {
        $headers[] = 'MIME-Version: 1.0';
        $headers[] = 'Content-type: text/html; charset="windows-1250"';
        $headers[] = 'Content-Transfer-Encoding: 7bit';
        $message = $this->HTMLBody;
      } elseif ($this->sendText && $this->sendHTML) {
        $boundary = '==MP_Bound_xyccr948x==';
        $headers[] = 'MIME-Version: 1.0';
        $headers[] = 'Content-type: multipart/alternative; boundary="' .
        $boundary . '"';

        $message = 'To je v�ced�ln� zpr�va ve form�tu MIME.' . "\n";
        $message .= '--' . $boundary . "\n";
        $message .= 'Content-type: text/plain; charset="windows-1250"' .
                    "\n";
        $message .= 'Content-Transfer-Encoding: 7bit' . "\n\n";
        $message .= $this->textBody  . "\n";
        $message .= '--' . $boundary . "\n";

        $message .= 'Content-type: text/html; charset="windows-1250"' . "\n";
        $message .= 'Content-Transfer-Encoding: 7bit' . "\n\n";
        $message .= $this->HTMLBody  . "\n";
        $message .= '--' . $boundary . '--';
      }

      $success = mail($this->toAddress, $this->subject, $message,
        join("\r\n", $headers));
      return $success;
    }
  }
}
?>