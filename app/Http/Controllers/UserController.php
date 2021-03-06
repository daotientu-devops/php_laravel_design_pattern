<?php

namespace App\Http\Controllers;

use App\Events\ServerCreated;
use App\Facades\Process;
use App\Jobs\SendEmail;
use App\Jobs\SendEmailUsingRedisQueue;
use App\Services\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * @var int
     */
    protected $limit = 10;

    /**
     * UserController constructor.
     * @param UserService $userService
     */
    public function __construct(UserService $userService)
    {
        return $this->userService = $userService;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $event = new ServerCreated(array('id' => '1'), 'Init broadcasting');
        print_r($event);
        $fullname = $this->userService->getName('Peter đại đế');
        echo $fullname . '<br/>';
        $othername = $this->userService->getOtherName();
        echo $othername . '<br/>';
        // Facade
        Process::process();
        // Dispatch job
        $details = array(
            'name' => 'DAO TIEN TU',
            'email' => 'daotientu@gmail.com'
        );
        $job = (new SendEmailUsingRedisQueue($details));//->delay(Carbon::now()->addMinutes(60));
        dispatch($job)->onQueue('email');
        return $this->userService->index($this->limit);
    }

    /**
     * @return mixed
     */
    public function count()
    {
        return $this->userService->count();
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function show($id)
    {
        return $this->userService->show($id);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function store(Request $request)
    {
        return $this->userService->store($request);
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function update(Request $request, $id)
    {
        return $this->userService->update($request, $id);
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function destroy($id)
    {
        return $this->userService->destroy($id);
    }
}
