<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\RegisteredUserDataTable;
use App\DataTables\UnregisteredUserDataTable;
use App\DataTables\UserDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Repositories\UserRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use App\Models\User;
use Auth;
use Response;

class UserController extends AppBaseController
{
    /** @var  UserRepository */
    private $userRepository;

    public function __construct(UserRepository $userRepo)
    {
        $this->userRepository = $userRepo;
    }

    /**
     * Display a listing of all Users.
     *
     * @param UserDataTable $userDataTable
     * @return Response
     */
    public function index(UserDataTable $userDataTable)
    {
        $user = Auth::user();
        return $userDataTable->render('admin.users.index', compact('user'));
    }

    /**
     * Display a listing of registered Users.
     *
     * @param UserDataTable $userDataTable
     * @return Response
     */
    public function registered(RegisteredUserDataTable $registeredUserDataTable)
    {
        $user = Auth::user();
        $viewTitle = 'Matriculados';
        return $registeredUserDataTable->render('admin.users.index', compact('user', 'viewTitle'));
    }

    /**
     * Display a listing of unregistered Users.
     *
     * @param UserDataTable $userDataTable
     * @return Response
     */
    public function unregistered(UnregisteredUserDataTable $unregisteredUserDataTable)
    {
        $user = Auth::user();
        $viewTitle = 'Não Matriculados';
        return $unregisteredUserDataTable->render('admin.users.index', compact('user', 'viewTitle'));
    }
}
