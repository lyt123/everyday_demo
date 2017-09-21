<?php
/* User:lyt123; Date:2017/9/11; QQ:1067081452 */
interface UserRepositoryInterface
{
    public function all();
}

class DbUserRepository implements UserRepositoryInterface
{
    public function all()
    {
        return User::all()->toArray();
    }
}

class UserController extends BaseController
{
    public function __construct(UserRepositoryInterface $users)
    {
        $this->users = $users;
    }

    public function getIndex()
    {
        $users=$this->users->all();
        return View::make('users.index', compact('users'));
    }
}

public function testIndexActionBindsUsersFromRepository()
{
    // Arrange...
    $repository = Mockery::mock('UserRepositoryInterface');
    $repository->shouldReceive('all')->once()->andReturn(array('foo'));
    App::instance('UserRepositoryInterface', $repository);
    // Act...
    $response  = $this->action('GET', 'UserController@getIndex');

    // Assert...
    $this->assertResponseOk();
    $this->assertViewHas('users', array('foo'));
}

interface BillerInterface {
    public function bill(array $user, $amount);
}

interface BillingNotifierInterface {
    public function notify(array $user, $amount);
}

class StripeBiller implements BillerInterface{
    public function __construct(BillingNotifierInterface $notifier)
    {
        $this->notifier = $notifier;
    }
    public function bill(array $user, $amount)
    {
        // Bill the user via Stripe...
        $this->notifier->notify($user, $amount);
    }
}

$biller = new StripeBiller(new SmsNotifier);