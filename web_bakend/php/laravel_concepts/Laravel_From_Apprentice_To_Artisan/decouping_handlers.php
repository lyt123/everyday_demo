<?php
/* User:lyt123; Date:2017/9/12; QQ:1067081452 */
class SendSMS{
    public function fire($job, $data)
    {
        $twilio = new Twilio_SMS($apiKey);
        $twilio->sendTextMessage(array(
            'to'=> $data['user']['phone_number'],
            'message'=> $data['message'],
        ));
        $user = User::find($data['user']['id']);
        $user->messages()->create(array(
            'to'=> $data['user']['phone_number'],
            'message'=> $data['message'],
        ));
        $job->delete();
    }
}

//优化
class User extends Eloquent {
    /**
     * Send the User an SMS message
     *
     * @param SmsCourierInterface $courier
     * @param string $message
     * @return SmsMessage
     */
    public function sendSmsMessage(SmsCourierInterface $courier, $message)
    {
        $courier->sendMessage($this->phone_number, $message);
        return $this->sms()->create(array(
            'to'=> $this->phone_number,
            'message'=> $message,
        ));
    }
}

class SendSMS {
    public function __construct(UserRepository $users, SmsCourierInterface $courier)
    {
        $this->users = $users;
        $this->courier = $courier;
    }
    public function fire($job, $data)
    {
        $user = $this->users->find($data['user']['id']);
        $user->sendSmsMessage($this->courier, $data['message']);
        $job->delete();
    }
}

class SmsTest extends PHPUnit_Framework_TestCase {
    public function testUserCanBeSentSmsMessages()
    {
        /**
         * Arrage ...
         */
        $user = Mockery::mock('User[sms]');
        $relation = Mockery::mock('StdClass');
        $courier = Mockery::mock('SmsCourierInterface');

        $user->shouldReceive('sms')->once()->andReturn($relation);

        $relation->shouldReceive('create')->once()->with(array(
            'to' => '555-555-5555',
            'message' => 'Test',
        ));

        $courier->shouldReceive('sendMessage')->once()->with(
            '555-555-5555', 'Test'
        );

        /**
         * Act ...
         */
        $user->sms_number = '555-555-5555'; //译者注： 应当为 phone_number
        $user->sendMessage($courier, 'Test');
    }
}