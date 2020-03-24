<?php

namespace ThallesTeodoro\BaseAdmin\App\Http\Controllers\Admin;

use Exception;
use App\Enums\UserRole;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use ThallesTeodoro\BaseAdmin\App\Helpers\Paginator;
use ThallesTeodoro\BaseAdmin\App\Interfaces\UserRepositoryInterface;

class UsersController extends Controller
{
    /**
     * User repository instance
     *
     * @var ThallesTeodoro\BaseAdmin\App\Interfaces\UserRepositoryInterface
     */
    private $userRepository;

    /**
     * Constructor method
     *
     * @param ThallesTeodoro\BaseAdmin\App\Interfaces\UserRepositoryInterface $userRepository
     */
    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (!empty($request->get('search')))
            $users = $this->userRepository->search($request->get('search'), auth()->user()->id);
        else
            $users = $this->userRepository->allOrderly('name', 'ASC', auth()->user()->id);

        return view('baseadmin::admin.pages.users.index', [
            'users' => Paginator::make($users, 20, null, [
                'path' => route('admin.users.index')
            ])
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = $this->getUserRoles();

        return view('baseadmin::admin.pages.users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'          => 'required|min:2',
            'email'         => 'required|email|unique:users,email',
            'password'      => 'required|confirmed|min:8',
            'user_role'     => 'required|in:' . implode(', ', UserRole::getValues()),
        ]);

        $data = [
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'password' => bcrypt($request->get('password')),
            'user_role' => $request->get('user_role'),
        ];

        try {
            $user = $this->userRepository->add($data);

            if ($user) {
                return redirect()
                    ->route('admin.users.edit', $user->id)
                    ->with('success', 'Usuário cadastrado com sucesso!.');
            }

            throw new Exception();
        } catch (Exception $e) {
            return back()
                ->with('error', 'Usuário não encontrado.')
                ->withInput();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = $this->userRepository->getById($id);

        if ($user && $user->id != auth()->user()->id) {
            $roles = $this->getUserRoles();
            return view('baseadmin::admin.pages.users.edit', compact('user', 'roles'));
        }

        return back()->with('error', 'Usuário não encontrado.');
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
        $user = $this->userRepository->getById($id);

        if ($user && $user->id != auth()->user()->id) {
            $request->validate([
                'name'      => 'required|min:3|string',
                'email'     => 'required|email',
                'user_role' => 'required|in:' . implode(', ', UserRole::getValues())
            ]);

            $data = [
                'name'      => $request->get('name'),
                'email'     => $request->get('email'),
                'user_role' => $request->get('user_role'),
            ];

            if(!empty($request->get('password'))) {
                $request->validate([
                    'password' => 'required|min:8|string|confirmed'
                ]);

                $data['password'] = bcrypt($request->get('password'));
            }

            try {
                $user = $this->userRepository->update($id, $data);

                if ($user) {
                    return back()->with('success', 'Usuário atualizado com sucesso!.');
                }

                throw new Exception();
            } catch (Exception $e) {
                return back()->with('error', 'Não foi possível atualizar os dados do usuário.');
            }
        } else {
            return back()->with('error', 'Usuário não encontrado.');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = $this->userRepository->getById($id);

        if ($user && $user->id != auth()->user()->id) {
            try {
                $userName = $user->name;

                if ($this->userRepository->delete($id)) {
                    return back()->with('success', "Usuário $userName removido com sucesso.");
                }

                throw new Exception();
            } catch (Exception $e) {
                return back()->with('error', 'Não foi possível remover o usuário.');
            }
        } else {
            return back()->with('error', 'Usuário não encontrado.');
        }
    }

    /**
     * Retrun the translated keys of User Roles
     *
     * @return array
     */
    private function getUserRoles() {
        $roles_old = UserRole::toSelectArray();

        $roles = [];

        foreach($roles_old as $key => $role) {
            $roles[$key] = UserRole::getTranslatedKey($key);
        }

        return $roles;
    }
}
