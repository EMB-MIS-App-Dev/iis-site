<?php defined('BASEPATH') OR exit('No direct script access allowed');

$config = array(
    'protocol' => 'smtp', // 'mail', 'sendmail', or 'smtp'
    'smtp_host' => 'smtp.office365.com',
    'smtp_port' => 587,
    'smtp_user' => 'r7support@emb.gov.ph',
    'smtp_pass' => 'Agentx3mbvii158459',
    'smtp_crypto' => 'tls', //can be 'ssl' or 'tls' for example
    'mailtype' => 'text', //plaintext 'text' mails or 'html'
    'smtp_timeout' => '4', //in seconds
    'charset' => 'UTF-8',
    // 'charset' => 'iso-8859-1',
    'wordwrap' => TRUE
);

?>
