<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\SupervisorRequest;
use App\Models\Role;
use App\Models\User;
use App\Services\ImageService;
use App\Traits\ImageUploadTrait;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\File;

class SupervisorController extends Controller
{
    use ImageUploadTrait;

    /**
     * @var ImageService
     */
    protected ImageService $imageService;


    public function __construct(ImageService $imageService)
    {
        $this->imageService = $imageService;
    }

    /**
     * get all admins user
     * @return View
     */
    public function index(): View
    {
        $supervisors = User::whereRoleIs('admin')
            ->when(\request()->keyword != null, function ($query) {
                $query->search(\request()->keyword);
            })
            ->when(\request()->status != null, function ($query) {
                $query->whereStatus(\request()->status);
            })
            ->orderBy(\request()->sortBy ?? 'id', \request()->orderBy ?? 'desc')
            ->paginate(\request()->limitBy ?? 10);

        return view('backend.supervisors.index', compact('supervisors'));
    }

    /**
     * @return View
     */
    public function create(): View
    {

        $roles = Role::where('name', '!=', 'user')->orderBy('created_at')->get(['id', 'name']);

        return view('backend.supervisors.create', compact('roles'));
    }

    public function show(User $supervisor): View
    {
        return view('backend.supervisors.show', compact('supervisor'));
    }

    public function edit(User $supervisor): View
    {

        $roles = Role::where('name', '!=', 'user')->orderBy('created_at')->get(['id', 'name']);
        $supervisorroles = $supervisor->roles->pluck('name')->toArray();
        return view('backend.supervisors.edit', compact('supervisor', 'roles', 'supervisorroles'));
    }

    public function store(SupervisorRequest $request): RedirectResponse
    {

        if ($request->hasFile('user_image')) {
            $supervisorImage = $this->imageService->storeUserImages($request->username, $request->user_image);
        }

        $supervisor = User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => bcrypt($request->password),
            'status' => $request->status,
            'email_verified_at' => now(),
            'user_image' => $supervisorImage ?? NULL
        ]);

        $supervisor->markEmailAsVerified();

        // Assigning Permissions to this supervisor
        if (isset($request->roles)) {
            $supervisor->attachRoles($request->roles);
        }

        return redirect()->route('admin.supervisors.index')->with([
            'message' => 'Created successfully',
            'alert-type' => 'success'
        ]);
    }

    /**
     * @param SupervisorRequest $request
     * @param User $supervisor
     * @return RedirectResponse
     */
    public function update(SupervisorRequest $request, User $supervisor): RedirectResponse
    {

        if ($request->hasFile('user_image')) {
            if ($supervisor->user_image) {
                $this->imageService->unlinkImage($supervisor->user_image, 'users');
            }
            $supervisorImage = $this->imageService->storeUserImages($request->username, $request->user_image);
        }

        if ($request->password){
            $password = bcrypt($request->password);
        }

        $supervisor->update([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'phone' => $request->phone,
            'status' => $request->status,
            'receive_email' => $request->receive_email,
            'user_image' => $supervisorImage ?? $supervisor->user_image,
            'password' => $password ?? $supervisor->password
        ]);


        if ($request->has('roles')) {
            foreach ($supervisor->roles as $role) {
                $supervisor->detachRole($role);
            }

            $supervisor->attachRoles($request->get('roles'));
        }

        return redirect()->route('admin.supervisors.index')->with([
            'message' => 'Updated successfully',
            'alert-type' => 'success'
        ]);
    }


    /**
     * @param User $supervisor
     * @return RedirectResponse
     */
    public function destroy(User $supervisor): RedirectResponse
    {

        if ($supervisor->user_image) {
            $this->imageService->unlinkImage($supervisor->user_image, 'users');
        }

        $supervisor->delete();

        return redirect()->route('admin.supervisors.index')->with([
            'message' => 'Deleted successfully',
            'alert-type' => 'success'
        ]);
    }

    public function removeImage(User $supervisor): RedirectResponse
    {

        if (File::exists('storage/images/users/'. $supervisor->user_image)) {
            unlink('storage/images/users/'. $supervisor->user_image);
            $supervisor->user_image = null;
            $supervisor->save();
        }

        return back()->with([
            'message' => 'Image deleted successfully',
            'alert-type' => 'success'
        ]);
    }
}
