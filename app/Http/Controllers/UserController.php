<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Transformers\UserTransformer;
use App\Repositories\Contracts\UserRepository;

use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Constructor
     *
     * @param UserRepository $users
     * @param UserTransformer $transformer
     */
    public function __construct(UserRepository $repository, UserTransformer $transformer)
    {
        $this->repository = $repository;
        $this->resourceType = $this->repository->resourceType();
        parent::__construct($transformer);
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->has('page')) {
            if ($errors = $this->validate($request, ['page' => 'integer'])) {
                return $this->sendInvalidFieldResponse($errors);
            }
            return $this->respondWithCollection($this->repository->paginate($request->page));
        }
        return $this->respondWithCollection($this->repository->all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = $this->repository->find($id);

        if (!$user instanceof User) {
            return $this->sendNotFoundResponse("The user with id {$id} doesn't exist");
        }

        // Authorization
        // $this->authorize('show', $user);

        return $this->respondWithItem($user);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Since, with Laravel|Lumen passport doesn't restrict
     * a client requesting any scope. we have to restrict it.
     * http://stackoverflow.com/questions/39436509/laravel-passport-scopes
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function createAccessToken(Request $request)
    {
        if ($errors = $this->validate($request, [
            'grant_type'    => 'required|alpha',
            'client_id'     => 'required|alpha_num',
            'client_secret' => 'required|alpha_num',
            'username'      => 'required|email',
            'password'      => 'required|string|min:8',
            'scope'         => 'alpha',
        ])) {
            return $this->sendInvalidFieldResponse($errors);
        }

        $user = null;
        if ($request->username && $request->grant_type === 'password') {
            $user = $this->repository->findBy('email', $request->username);
        }

        if ($user instanceof User) {
            // user with basic role can only request for basic scope
            if ($user->role === User::BASIC_ROLE) {
                $request->request->add(['scope' => 'basic']);
            }
        } else {
            // client_credentials grant can only request for basic scope
            $request->request->add(['scope' => 'basic']);
        }

        $tokenRequest = $request->create('/oauth/token', 'post', $request->all());

        // forward the request to the oauth token request endpoint
        return app()->dispatch($tokenRequest);
    }
}
