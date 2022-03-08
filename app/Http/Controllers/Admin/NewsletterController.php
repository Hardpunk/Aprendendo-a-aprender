<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\NewsletterDataTable;
use App\Http\Controllers\AppBaseController;
use App\Http\Requests\CreateNewsletterRequest;
use App\Newsletter;
use App\Repositories\NewsletterRepository;
use Auth;
use Exception;
use Flash;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Response;

class NewsletterController extends AppBaseController
{
    /** @var  NewsletterRepository */
    private $newsletterRepository;

    public function __construct(NewsletterRepository $newsletterRepo)
    {
        $this->newsletterRepository = $newsletterRepo;
    }

    /**
     * Display a listing of the Newsletter.
     *
     * @param  NewsletterDataTable  $newsletterDataTable
     * @return mixed
     */
    public function index(NewsletterDataTable $newsletterDataTable)
    {
        $user = Auth::user();
        return $newsletterDataTable->render('admin.newsletters.index', compact('user'));
    }

    /**
     * Store a newly created Newsletter in storage.
     *
     * @param  CreateNewsletterRequest  $request
     *
     * @return JsonResponse|RedirectResponse
     */
    public function store(CreateNewsletterRequest $request)
    {
        $input = $request->all();
        $email = $input['email'];

        if (!Newsletter::where('email', $email)->exists()) {
            $newsletter = $this->newsletterRepository->create($input);
        }

        if ($request->ajax()) {
            return response()->json(['status' => true, 'message' => 'E-mail cadastrado com sucesso.']);
        }

        Flash::success('E-mail cadastrado com sucesso.');

        return redirect(route('admin.newsletters.index'));
    }

    /**
     * Remove the specified Newsletter from storage.
     *
     * @param  int  $id
     *
     * @return RedirectResponse
     * @throws Exception
     */
    public function destroy($id)
    {
        $newsletter = $this->newsletterRepository->find($id);

        if (empty($newsletter)) {
            Flash::error('E-mail não encontrado');

            return redirect(route('admin.newsletters.index'));
        }

        $this->newsletterRepository->delete($id);

        Flash::success('E-mail excluído com sucesso.');

        return redirect(route('admin.newsletters.index'));
    }
}
