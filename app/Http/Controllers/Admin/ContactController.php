<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\ContactDataTable;
use App\Http\Controllers\AppBaseController;
use App\Http\Requests\CreateContactRequest;
use App\Repositories\ContactRepository;
use Auth;
use Exception;
use Flash;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Response;

class ContactController extends AppBaseController
{
    /** @var  ContactRepository */
    private $contactRepository;

    public function __construct(ContactRepository $contactRepo)
    {
        $this->contactRepository = $contactRepo;
    }

    /**
     * Display a listing of the Contact.
     *
     * @param  ContactDataTable  $contactDataTable
     * @return Response
     */
    public function index(ContactDataTable $contactDataTable)
    {
        $user = Auth::user();
        return $contactDataTable->render('admin.contacts.index', compact('user'));
    }

    /**
     * Store a newly created Contact in storage.
     *
     * @param  CreateContactRequest  $request
     * @return RedirectResponse|JsonResponse
     */
    public function store(CreateContactRequest $request)
    {
        $input = $request->except('g-recaptcha-response');

        $contact = $this->contactRepository->create($input);

        if ($request->ajax()) {
            return response()->json(['status' => true, 'message' => 'Contato enviado com sucesso.']);
        }

        Flash::success('Contato salvo com sucesso.');
        return redirect(route('admin.contacts.index'));
    }

    /**
     * Display the specified Contact.
     *
     * @param  int  $id
     *
     * @return View|RedirectResponse
     */
    public function show($id)
    {
        $user = Auth::user();
        $contact = $this->contactRepository->find($id);

        if (empty($contact)) {
            Flash::error('Contato não encontrado.');

            return redirect(route('admin.contacts.index'));
        }

        return view('admin.contacts.show', compact('contact', 'user'));
    }

    /**
     * Remove the specified Contact from storage.
     *
     * @param  int  $id
     *
     * @return RedirectResponse
     * @throws Exception
     */
    public function destroy($id)
    {
        $contact = $this->contactRepository->find($id);

        if (empty($contact)) {
            Flash::error('Contato não encontrado');

            return redirect(route('admin.contacts.index'));
        }

        $this->contactRepository->delete($id);

        Flash::success('Contato excluído com sucesso.');

        return redirect(route('admin.contacts.index'));
    }
}
