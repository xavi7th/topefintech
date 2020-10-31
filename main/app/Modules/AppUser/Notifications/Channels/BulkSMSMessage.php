<?php

namespace App\Modules\AppUser\Notifications\Channels;

use Illuminate\Support\Facades\Http;
use Illuminate\Notifications\Notification;

class BulkSMSMessage
{
  /**
   * The sms content.
   *
   * @var string
   */
  public $sms;

  /**
   * This is what the recipients of the messages
   * will see as the sender of the message. This
   * must be 11 characters or less. Longer
   * sender ids are automatically shortened to
   * meet the standard. This should be URL
   * encoded when using the GET protocol.
   *
   * @var string
   */
  public $from = 'SmartMonie';

  /**
   * These are the phone numbers the messages are to be sent to.
   * Multiple phone numbers are to be separated by a comma ‘,’ or space.
   * Large quantities of phone numbers can be called via the POST method.
   *
   * Recipients via the GET method are advised to be limited to 100 phone numbers at once.
   * This is to avoid the possibilities of running into the HTTPS
   * Error 400 (Bad Request - Request Too Long).
   *
   * @var string
   */
  public $to;

  /**
   *	Set how you want the phone numbers on DND to be handled.
   *
   *  The available options are 1, 2, 3, 4 and 5.
   *  1 is for "Get A Refund for MTN DND numbers"
   *  2 is for "Resend to MTN DND Numbers via Hosted SIM"
   *  3 is for "Send to All Nigerian Numbers Via Hosted SIM Card"
   *  4 is for "Dual-Backup Guaranteed Delivery to All Active Nigerian GSM Numbers"
   *  5 is for "Dual-Dispatch Guaranteed Delivery to All Active Nigerian GSM Numbers"
   *  Options 2-5 is only available after KYC Verification. Default DND option is 2 (i.e. "Resend to MTN DND numbers via Hosted SIM") if your have completed your KYC Verification.
   *
   * @var int
   */
  public $dnd = 3;

  /**
   * The API KEY.
   * This is the access token that authorizes the delivery of the message. You can get your api_key from
   * https://www.bulksmsnigeria.com/app/api-settings
   *
   * @var string
   */
  public $api_token;

  /**
   * Create a new message instance.
   *
   * @param  string  $sms_message
   * @return void
   */
  public function __construct($sms_message = '')
  {
    $this->sms = $sms_message;
  }

  /**
   * Set the message content.
   *
   * @param  string  $sms_message
   * @return $this
   */
  public function sms_message($sms_message)
  {
    $this->sms = $sms_message;
    return $this;
  }

  /**
   * Set the phone number the message should be sent from.
   *
   * @param  string  $sender
   * @return $this
   */
  public function from($sender_id)
  {
    $this->sender = $sender_id;
    return $this;
  }

  /**
   * Set the phone number the message should be sent from.
   *
   * @param  string  $sender
   * @return $this
   */
  public function to($recipients)
  {
    $this->to = $recipients;
    return $this;
  }

  /**
   * Send the given notification.
   *
   * @param  mixed  $notifiable
   * @param  \Illuminate\Notifications\Notification  $notification
   * @return void
   */
  public function send($notifiable, Notification $notification)
  {
    $msg_obj = $notification->toBulkSMS($notifiable);
    $msg_obj->api_token = config('services.bulk_sms.api_token');

    /** ! This will always overwrite the ID set by the from(). Refactor */
    $msg_obj->from = config('services.bulk_sms.from');
    $url = config('services.bulk_sms.endpoint');

    $response = Http::post($url, [
      'api_token' => $msg_obj->api_token,
      'from' => $msg_obj->from,
      'to' => $msg_obj->to,
      'body' => $msg_obj->sms,
      'dnd' => $this->dnd,
    ]);

    /**
     * ? Create a DB table to save the response from the send attempt so that admins can see how the SMS gateway is working
     */
    // $promise->then(
    // 	function (ResponseInterface $res) {
    // 		echo $res->getStatusCode() . "\n";
    // 	},
    // 	function (RequestException $e) {
    // 		echo $e->getMessage() . "\n";
    // 		echo $e->getRequest()->getMethod();
    // 	}
    // );

    // $response = $request->send();



    // dd($response->getBody());
  }
}
