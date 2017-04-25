<?php

namespace App\Http\Controllers\Auth;

//use App\Exceptions\ValidatorException;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\SendRegisterEmailRequest;
//use App\Http\Requests\RegisterRequest;
//use App\LoginRecords;
use App\User;
use App\Http\Controllers\Controller;

use App\Jobs\SendEmail;
use Carbon\Carbon;
use Illuminate\Http\Request;
//use DB;
//use Auth;
//use Validator;
//use JWTAuth;
//use JWTFactory;
//use Mail;

class AuthController extends Controller
{


    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //        $this->middleware('jwt.refresh', ['only'=>'refresh']);
    }


    /**
     * Description : 发送注册验证码
     * Auth : Shelter
     *
     * @param SendRegisterEmailRequest $req
     * @return \Illuminate\Http\JsonResponse
     */
    public function sendRegisterCode(SendRegisterEmailRequest $req)
    {
        $email = $req->input('email');

        $code = str_random(8); //生成随机验证码

        Mail::raw('验证码是：'. $code, function ($message) use ($code) {
            $to = '1067081452@qq.com';
            $message ->to($to)->subject('验证码');
        });

        DB::table('register_code')->insert([
            'email'      => $email,
            'code'       => $code,
            'created_at' => Carbon::now()->toDateTimeString()
        ]);

        return ajax_ok([], '发送成功');
    }

    /**
     * Description : 注册
     * Auth : Shelter
     *
     * @param Request $req
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(RegisterRequest $req)
    {
        $post_data = $req->all();

        //TODO:验证验证码
        //        $this->testEmailCode($post_data['email'], $post_data['code']);

        $data = [
            'email'       => $post_data['email'],
            'phone'       => $post_data['phone'],
            'password'    => $post_data['password'],
            't_name'      => $post_data['t_name'],
            'v_name'      => $post_data['v_name'],
            'last_ip'     => $req->getClientIp(),
            'last_time'   => Carbon::now()->toDateTimeString()
        ];

        $user = User::create($data);


        return ajax_ok([
            'id'      => $user->id,
            'email'   => $post_data['email'],
            'v_name'  => $post_data['v_name'],
            'v_head'  => null,
            'is_auth' => false   //是否认证开发者
        ], '注册成功');
    }

    /**
     * Description : 登陆认证
     * Auth : Shelter
     *
     * @param Request $req
     * @return \Illuminate\Http\JsonResponse
     */
    public function authorize(LoginRequest $req)
    {
        dd();
        return $this->auth($req, false);
    }

    /**
     * Description : 管理员登陆
     * Auth : Shelter
     *
     * @param LoginRequest $req
     * @return \Illuminate\Http\JsonResponse
     */
    public function adminAuthorize(LoginRequest $req)
    {
        return $this->auth($req, true);
    }

    /**
     * Description : refresh
     * Auth : Shelter
     *
     */
    public function refresh()
    {
        return ajax_ok();
    }

    /**
     * Description : auth
     * Auth : Shelter
     *
     * @param Request $req
     * @param $is_admin
     * @return \Illuminate\Http\JsonResponse
     * @throws ValidatorException
     */
    public function auth(Request $req, $is_admin)
    {
        $post_data = $req->only('email', 'password');

        //验证验证码
        //        if(LoginRecords::isNeedCode($post_data['email'])) {
        //            $code = $req->only('code');
        //            $this->testAuthorizeCode($code);
        //        }
        $user_data = DB::table('users')->where($post_data)->get();
        dd($user_data);

        if(1) {

            if($is_admin) {
                if(!$req->user()->is_admin)
                    return ajax_error('非管理员', 401);
            }

            $data = [
                'token'   => $token,
                'id'      => $req->user()->id,
                'email'   => $req->user()->email,
                'v_name'  => $req->user()->v_name,
                'v_head'  => $req->user()->v_head,
            ];

            if(!$is_admin) $data['is_auth'] = $req->user()->is_auth;

            return ajax_ok($data, '登陆成功');
        }
        else {
            //登陆信息错误记录，下次登陆需要验证码
            LoginRecords::addRecord($post_data['email']);
            return ajax_error('账号或密码错误');
        }
    }


    /**
     * Description : 验证登陆时的验证码
     * Auth : Shelter
     *
     * @param $code
     * @return array|bool
     */
    public function testAuthorizeCode($code)
    {
        $rules = ['code' => 'required|captcha'];
        $validator = Validator::make($code, $rules, [
            'code.required' => '请输入验证码',
            'code.captcha'  => '验证码错误'
        ]);

        if ($validator->fails())
            abort(422, current($validator->errors()->all()));
    }


    /**
     * Description : 验证验证码是否正确
     * Auth : Shelter
     *
     * @param $email
     * @param $code
     */
    public function testEmailCode($email, $code)
    {
        $overdue_time = Carbon::createFromTimestamp(time() - 3600)->toDateTimeString();

        $created_at = DB::table('register_code')
            ->where('email', '=', $email)
            ->where('code', '=', $code)
            ->value('created_at');

        if( !$created_at ||
            strtotime($created_at) > strtotime($overdue_time)
        )
            abort(422, '验证码错误或者已经失效');

        // 1/20的概率清除无效的验证码（1个小时之前）
        if (rand(1, 20) == 1) {
            DB::table('register_code')
                ->where('created_at', '<', $overdue_time)
                ->delete();
        }
    }
}
