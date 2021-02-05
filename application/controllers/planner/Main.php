<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
error_reporting(E_ALL);
// error_reporting(0);

class Main extends CI_Controller
{
   private $thisdata;
   function __construct()
   {
      parent::__construct();
      // USER SESSION CHECK
      if ( empty($this->session->userdata('token')) ) {
         echo "<script>alert('Session Timeout. Please Re-Login.'); window.location.href='".base_url()."';</script>";
      }

      $this->load->model('Embismodel');
      $this->load->helper(array('form', 'url'));

      $this->load->library('session');
      $this->load->library('form_validation');
      $this->load->library('upload');
      $this->load->library('encryption');

      date_default_timezone_set("Asia/Manila");
      // DATABASE
      $this->sql_details = array(
         'user' => $this->session->userdata('user'),
         'pass' => $this->session->userdata('pass'),
         'db'   => $this->session->userdata('db'),
         'host' => $this->session->userdata('host'),
      );
      // USER DETAILS SESSION
      $this->thisdata['user'] = array(
         'id'      => $this->session->userdata('userid'),
         'token'   => $this->session->userdata('token'),
         'region'  => $this->session->userdata('region'),
         'secno'   => $this->session->userdata('secno'),
         'divno'   => $this->session->userdata('divno'),
         'office'  => $this->session->userdata('office'),
      );
   }

   function index()
   {
      $this->load->view('includes/common/header');
      $this->load->view('includes/common/sidebar');
      $this->load->view('includes/common/nav');
      $this->load->view('includes/common/footer');

      $this->load->view('planner/include/css');
      $this->load->view('planner/modal/add_schedule');
      $this->load->view('planner/include/custom_footer');

      $order = $this->db->order_by('fname ASC');
      $where = array(
         'region'         => $this->thisdata['user']['region'],
         'office'         => $this->thisdata['user']['office'],
         'designation !=' => 'Administrator',
         'verified'       => '1',
         'userid !='      => $this->thisdata['user']['id'],
      );
      $data['user_list'] = $this->Embismodel->selectdata('acc_credentials','*', $where, $order);
      $data['region_list'] = $this->Embismodel->selectdata('acc_region','*', '');

      $this->load->view('planner/dashboard', $data);
   }

   private function validate_session()
   {
      $where_ucred = array(
         'userid'   => $this->thisdata['user']['id'],
         'verified' => 1,
      );
      $session_ucred = $this->Embismodel->selectdata('acc_credentials', '*', $where_ucred)[0];

      if($session_ucred['region'] != $this->thisdata['user']['region'] || $session_ucred['secno'] != $this->thisdata['user']['secno'] || $session_ucred['divno'] != $this->thisdata['user']['divno']) {
         $this->thisdata = array(
            'user_id'     => $session_ucred['userid'],
            'user_region' => $session_ucred['region'],
            'user_token'  => $session_ucred['token'],
         );
         $this->thisdata['user'] = array(
            'id'      => $session_ucred['userid'],
            'token'   => $session_ucred['token'],
            'region'  => $session_ucred['region'],
            'secno'   => $session_ucred['secno'],
            'divno'   => $session_ucred['divno'],
         );
      }
   }

   private function _is_empty($data="", $empt="", $added="") { return !empty($data) ? $data.$added : $empt; }

   private function user_fullname($user_id="")
   {
      $result = $this->db->where('userid ='.$user_id)->from('acc_credentials')->get()->row(0);

      $data['email'] = $result->email;
      $data['fullname'] = !empty($result) ? $this->_is_empty($result->title, '', ' ')
      .$result->fname.' '
      .$this->_is_empty($result->mname[0], '', '. ')
      .$result->sname.' '
      .$this->_is_empty($result->suffix, '') : '';

      return $data;
   }

   function submit()
   {
      $post = $this->input->post();

      $data = array(
         "activities"      => $post['activities'],
         "location"        => $post['location'],
         "start_date"      => $post['start_date'],
         "end_date"        => $post['end_date'],
         "status"          => 'Upcoming',
         "remarks"         => $post['remarks'],
         "area_scope"      => implode(';', $post['area_scope']),
      );
      $result = $this->Embismodel->updatedata($data, 'psched_list', array('id' => $post['sched_id']));

      if($result) {
         if($this->sample_submit($post))
         {
            redirect(base_url('planner/main'));
         }
         else {
            echo 'failed';
         }
      } else {
         print_r($data);
         exit;
      }
   }

   function sample_submit($post)
   {
      $this->load->library("phpmailer_library");
      $mail = $this->phpmailer_library->load();

      $psched_details = $this->Embismodel->selectdata('psched_list', '*', array('id' => $post['sched_id']));
      $organizer_details = $this->user_fullname($psched_details[0]['created_by']);

      $participant_actions = '';

      try {
         //Server settings
         $mail->isSMTP();                                            // Send using SMTP
         $mail->Host       = 'smtp.office365.com';                       // Specify main and backup server
         $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
         $mail->Username   = 'r7support@emb.gov.ph';                   // SMTP username
         $mail->Password   = 'Agentx3mbvii158459';               // SMTP password
         $mail->SMTPSecure = 'tls';                            // Enable encryption, 'ssl' also accepted
         $mail->Port       = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
         $mail->isHTML(true);                                  // Set email format to HTML

         //Recipients
         $mail->setFrom('r7support@emb.gov.ph', 'R7 Support');

         $invited_emails = $this->db->select('cred.email')
         ->from('psched_userlist p_user')
         ->join('acc_credentials cred', 'p_user.user_id = cred.userid')
         ->where(array('sched_id' => $post['sched_id']))
         ->group_by('p_user.sched_id')->get()->result_array();

         $mail->addAddress($organizer_details['email']);
         foreach ($invited_emails as $key => $email) {
            $mail->addAddress($email['email']);
            $participant_actions .= "ATTENDEE;CUTYPE=INDIVIDUAL;ROLE=REQ-PARTICIPANT;PARTSTAT=NEEDS-ACTION;RSVP=TRUE;X-NUM-GUESTS=0:MAILTO:".$email['email']."\r\n";
         }

         $location   = $post['location'];

         $startDate  = date('Ymd', strtotime($post['start_date']));
         $endDate    = date('Ymd', strtotime($post['end_date']));
         $startTime  = date('hi', strtotime($post['start_date']));
         $endTime    = date('hi', strtotime($post['end_date']));

         $subject    = $post['activities'];
         $desc       = $post['remarks'];

         $organizer = $organizer_details['fullname'];
         $organizer_email = $organizer_details['email'];

         // ---- TEST DATA INPUTS
         //
         // $mail->addAddress('albert_parpan@emb.gov.ph');
         // $mail->addAddress('r7support@emb.gov.ph');
         //
         // $location   = 'MS Teams - Office';
         //
         // $startDate  = date('Ymd');
         // $endDate    = date('Ymd');
         // $startTime  = date('hi');
         // $endTime    = date('hi');
         //
         // $subject    = 'Test Activity Subject';
         // $desc       = 'This is a Description. Test only, check check check one one one.';
         //
         // $organizer = 'Organizer Name';
         // $organizer_email = 'Organizer Email';
         //
         // $participant_actions = "ATTENDEE;CUTYPE=INDIVIDUAL;ROLE=REQ-PARTICIPANT;PARTSTAT=NEEDS-ACTION;RSVP=TRUE;X-NUM-GUESTS=0:MAILTO:r7support@emb.gov.ph\r\n";
         // $participant_actions .= "ATTENDEE;CUTYPE=INDIVIDUAL;ROLE=REQ-PARTICIPANT;PARTSTAT=NEEDS-ACTION;RSVP=TRUE;X-NUM-GUESTS=0:MAILTO:albert_parpan@emb.gov.ph\r\n";
         //
         // ---- TEST DATA INPUTS

         // ########################################     MAIN EMAIL CREATION     ############################################## //
         $text = "BEGIN:VCALENDAR\r\n
         VERSION:2.0\r\n
         PRODID:-//Deathstar-mailer//theforce/NONSGML v1.0//EN\r\n
         METHOD:REQUEST\r\n
         BEGIN:VEVENT\r\n
         UID:" . md5(uniqid(mt_rand(), true)) . "@emb.gov.ph\r\n
         DTSTAMP:" . gmdate('Ymd').'T'. gmdate('His') . "Z\r\n
         DTSTART:".$startDate."T".$startTime."00Z\r\n
         DTEND:".$endDate."T".$endTime."00Z\r\n
         SUMMARY:".$subject."\r\n
         ORGANIZER;CN=".$organizer.":mailto:".$organizer_email."\r\n
         LOCATION:".$location."\r\n
         DESCRIPTION:".$desc."\r\n
         ".$participant_actions."
         END:VEVENT\r\n
         END:VCALENDAR\r\n";

         $headers = "From: Sender\n";
         $headers .= 'Content-Type:text/calendar; Content-Disposition: inline; charset=utf-8;\r\n';
         $headers .= "Content-Type: text/plain;charset=\"utf-8\"\r\n"; #EDIT: TYPO
         $mail->Subject = $subject;
         $mail->Body = $desc;
         $mail->AltBody = $text; // in your case once more the $text string
         $mail->Ical = $text; // ical format, in your case $text string

         $mail->send();
         echo 'Message has been sent';

         return true;

      } catch (Exception $e) {
         echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
         return false;
      }
   }
}
?>
