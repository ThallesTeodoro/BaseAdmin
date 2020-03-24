<?php

namespace ThallesTeodoro\BaseAdmin\App\Http\Controllers\Admin;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use ThallesTeodoro\BaseAdmin\App\Interfaces\UserRepositoryInterface;

class ProfileController extends Controller
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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        $user = $this->userRepository->getAuthUser();

        return view('baseadmin::admin.pages.profile.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = $this->userRepository->getAuthUser();

        if ($id == $user->id) {
            $request->validate([
                'name'      => 'required|min:3|string',
                'email'     => 'required|email',
            ]);

            $data = [
                'name'      => $request->get('name'),
                'email'     => $request->get('email'),
            ];

            if(!empty($request->get('password'))) {
                $request->validate([
                    'password' => 'required|min:8|string|confirmed'
                ]);

                $data['password'] = bcrypt($request->get('password'));
            }

            try {
                if ($this->userRepository->update($id, $data)) {
                    return back()->with('success', 'Usuário atualizado com sucesso!.');
                }

                throw new Exception();
            }
            catch (Exception $e) {
                return back()->with('error', 'Não foi possível atualizar os dados.');
            }
        } else {
            return back()->with('error', 'Usuário não encontrado.');
        }
    }
}
