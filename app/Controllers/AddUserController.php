<?php

namespace App\Controllers;

use CodeIgniter\Shield\Controllers\RegisterController as ShieldRegister;
use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\Events\Events;
use CodeIgniter\Shield\Entities\User;
use CodeIgniter\Shield\Exceptions\ValidationException;
use CodeIgniter\Shield\Models\UserModel;
use CodeIgniter\Shield\Validation\ValidationRules;
use App\Models\CenterModel;
use App\Models\UserInfoModel;

class AddUserController extends ShieldRegister
{
    public function index()
    {       
        $centerModel = new CenterModel();
        $centers = $centerModel->findAll();

        return  view('template/header', ['page_title' => 'Add User']) . view('add', ['centers' => $centers]) . view('template/footer');
    }

    public function register(): RedirectResponse
    {   
        $userInfoModel = new UserInfoModel();
        $request = \Config\Services::request();
        $user_role = $request->getPost('user_role');
        $user_center = $request->getPost('user_center');
        $user_fname = $request->getPost('first_name');
        $user_lname = $request->getPost('last_name');

        $users = $this->getUserProvider();

        // Validate here first, since some things,
        // like the password, can only be validated properly here.
        $rules = $this->getValidationRules();

        if (! $this->validateData($this->request->getPost(), $rules, [], config('Auth')->DBGroup)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Save the user
        $allowedPostFields = array_keys($rules);
        $user              = $this->getUserEntity();
        $user->fill($this->request->getPost($allowedPostFields));

        // Workaround for email only registration/login
        if ($user->username === null) {
            $user->username = null;
        }

        try {
            $users->save($user);
        } catch (ValidationException $e) {
            return redirect()->back()->withInput()->with('errors', $users->errors());
        }

        // To get the complete user object with ID, we need to get from the database
        $user = $users->findById($users->getInsertID());
      

        // Add to default group
        $user->addGroup($user_role);        
        Events::trigger('register', $user);

        // Save user info
        $userInfoData = [
            'user_id'   => $user->id,
            'center'    => $user_center,
            'first_name'=> $user_fname,
            'last_name' => $user_lname,
            'dob'       => null,
        ];

        $userInfoModel->insert($userInfoData);

        // Set the user active
        $user->activate();

        // Success!
        return redirect()->to('/user/admin-list');
    }

    /**
     * Returns the User provider
     */
    protected function getUserProvider(): UserModel
    {
        $provider = model(setting('Auth.userProvider'));

        assert($provider instanceof UserModel, 'Config Auth.userProvider is not a valid UserProvider.');

        return $provider;
    }

    /**
     * Returns the Entity class that should be used
     */
    protected function getUserEntity(): User
    {
        return new User();
    }

    /**
     * Returns the rules that should be used for validation.
     *
     * @return         array<string, array<string, array<string>|string>>
     * @phpstan-return array<string, array<string, string|list<string>>>
     */
    protected function getValidationRules(): array
    {
        $rules = new ValidationRules();

        return $rules->getRegistrationRules();
    }

}
